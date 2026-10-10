<?php

use App\Models\Activity;
use App\Models\ActivityDetail;
use App\Models\Stock_movement as StockMovement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public ?array $selectedClient = null;
    public array $items = [];
    public ?string $paymentMethod = null;
    public string $note = '';
    public array $stockErrors = [];

    #[On('service-added')]
    public function addService(array $service): void
    {
        foreach ($this->items as $index => $item) {
            if ($item['service_id'] === $service['id']) {
                $this->items[$index]['quantity']++;
                return;
            }
        }

        $this->items[] = [
            'service_id' => $service['id'],
            'service_label' => $service['label'],
            'unit_price' => (float) $service['price'],
            'quantity' => 1,
            'discount' => 0,
            'format_name' => $service['format_name'] ?? null,
            'stock_id' => $service['stock_id'] ?? null,
            'stock_label' => $service['stock_label'] ?? null,
            'category_label' => $service['category_name'] ?? $service['category_label'] ?? null,
            'color' => $service['color'] ?? 'noir',
        ];
    }

    public function increment(int $index): void
    {
        if (isset($this->items[$index])) {
            $this->items[$index]['quantity']++;
        }
    }

    public function decrement(int $index): void
    {
        if (isset($this->items[$index]) && $this->items[$index]['quantity'] > 1) {
            $this->items[$index]['quantity']--;
        }
    }

    public function updatedItems(mixed $value, string $key): void
    {
        if (str_contains($key, 'quantity')) {
            $index = explode('.', $key)[0];
            if (isset($this->items[$index])) {
                $this->items[$index]['quantity'] = max(1, (int) $this->items[$index]['quantity']);
            }
        }

        if (str_contains($key, 'discount')) {
            $index = explode('.', $key)[0];
            if (isset($this->items[$index])) {
                $this->items[$index]['discount'] = min(100, max(0, (float) $this->items[$index]['discount']));
            }
        }
    }

    public function remove(int $index): void
    {
        if (isset($this->items[$index])) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function clear(): void
    {
        $this->items = [];
        $this->paymentMethod = null;
        $this->note = '';
        $this->stockErrors = [];
        $this->resetErrorBag();
    }

    public function getTotalsProperty(): array
    {
        $subtotal = 0;
        $total = 0;
        $totalItems = 0;

        foreach ($this->items as $item) {
            $lineBase = $item['unit_price'] * $item['quantity'];
            $lineTotal = $lineBase * (1 - ($item['discount'] / 100));

            $subtotal += $lineBase;
            $total += $lineTotal;
            $totalItems += $item['quantity'];
        }

        return [
            'subtotal' => round($subtotal, 2),
            'total' => round($total, 2),
            'total_items' => $totalItems,
            'discount' => round($subtotal - $total, 2),
        ];
    }

    public function getStockRequirementsProperty(): array
    {
        $requirements = [];

        foreach ($this->items as $item) {
            $stockId = $item['stock_id'] ?? null;
            if (!$stockId) {
                continue;
            }

            if (!isset($requirements[$stockId])) {
                $requirements[$stockId] = [
                    'stock_id' => $stockId,
                    'stock_label' => $item['stock_label'] ?? "Stock #{$stockId}",
                    'required' => 0,
                ];
            }

            $requirements[$stockId]['required'] += $item['quantity'];
        }

        return $requirements;
    }

    protected function checkStockAvailability(): array
    {
        $errors = [];
        $requirements = $this->stockRequirements;

        foreach ($requirements as $stockId => $req) {
            $available = StockMovement::where('stock_id', $stockId)->sum('in_stock');

            if ($req['required'] > $available) {
                $errors[] = sprintf('%s : besoin de %d unité(s), %d disponible(s).', $req['stock_label'], $req['required'], $available);
            }
        }

        return $errors;
    }

    protected function generateRef(): string
    {
        $year = now()->year;
        $prefix = "ACT-{$year}-";

        $lastActivity = Activity::where('ref', 'like', "{$prefix}%")
            ->orderByDesc('ref')
            ->first();

        $nextNumber = $lastActivity ? ((int) substr($lastActivity->ref, strlen($prefix))) + 1 : 1;

        return $prefix . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    }

    protected function computeCostPrice(?int $stockId, int $quantity): float
    {
        if (!$stockId) {
            return 0;
        }

        $lastEntry = StockMovement::where('stock_id', $stockId)
            ->where('movement_type', 'entry')
            ->orderByDesc('entry_stock')
            ->orderByDesc('id')
            ->first();

        if (!$lastEntry || $lastEntry->initial_stock <= 0) {
            return 0;
        }

        $costPerUnit = $lastEntry->provider_price / $lastEntry->initial_stock;

        return round($costPerUnit * $quantity, 2);
    }

    protected function decrementStockFifo(int $stockId, int $quantity): void
    {
        $remaining = $quantity;

        $movements = StockMovement::where('stock_id', $stockId)
            ->where('movement_type', 'entry')
            ->where('in_stock', '>', 0)
            ->orderBy('created_at')
            ->orderBy('id')
            ->lockForUpdate()
            ->get();

        foreach ($movements as $movement) {
            if ($remaining <= 0) {
                break;
            }

            $take = min($movement->in_stock, $remaining);
            $movement->in_stock -= $take;
            $movement->save();

            $remaining -= $take;
        }

        if ($remaining > 0) {
            throw new \RuntimeException("Impossible de décrémenter le stock #{$stockId} : manque {$remaining} unité(s).");
        }
    }

    public function save()
    {
        $this->stockErrors = [];
        $this->resetErrorBag();

        // 1. Validations
        if (!$this->selectedClient) {
            $this->addError('client', 'Veuillez sélectionner un client.');
            return;
        }

        if (empty($this->items)) {
            $this->addError('cart', 'Le panier est vide.');
            return;
        }

        if (!$this->paymentMethod) {
            $this->addError('payment', 'Veuillez sélectionner un mode de paiement.');
            return;
        }

        // 2. Vérification des stocks
        $errors = $this->checkStockAvailability();
        if (!empty($errors)) {
            $this->stockErrors = $errors;
            return;
        }

        // 3. Enregistrement en base de données
        DB::transaction(function () {
            $activity = Activity::create([
                'ref' => $this->generateRef(),
                'client_id' => $this->selectedClient['id'],
                'total_price' => $this->totals['total'],
                'payment_method' => $this->paymentMethod,
                'note' => $this->note ?: null,
            ]);

            foreach ($this->items as $item) {
                $lineTotal = $item['unit_price'] * $item['quantity'] * (1 - ($item['discount'] / 100));

                ActivityDetail::create([
                    'activity_id' => $activity->id,
                    'service_id' => $item['service_id'],
                    'service_label' => $item['service_label'],
                    'unit_price' => $item['unit_price'],
                    'cost_price' => $this->computeCostPrice($item['stock_id'] ?? null, $item['quantity']),
                    'quantity' => $item['quantity'],
                    'discount' => $item['discount'],
                    'total_line' => round($lineTotal, 2),
                ]);
            }

            foreach ($this->stockRequirements as $stockId => $req) {
                $this->decrementStockFifo($stockId, $req['required']);
            }
        });

        return redirect()->route('activities.index')->with('success', 'Activité enregistrée avec succès.');
    }
};
?>

<div>
    @if (count($items) > 0)

        {{-- Lignes du panier --}}
        <div class="d-flex flex-column gap-3">
            @foreach ($items as $index => $item)
                <div wire:key="cart-item-{{ $item['service_id'] }}" class="border rounded-3 p-3">

                    <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                        <div class="flex-grow-1 min-width-0">
                            <div class="fw-semibold">{{ $item['service_label'] }}</div>
                            <div class="text-secondary small d-flex flex-wrap gap-2">
                                @if ($item['format_name'])
                                    <span><i class="bi bi-aspect-ratio me-1"></i>{{ $item['format_name'] }}</span>
                                @endif
                                @if ($item['category_label'])
                                    <span><i class="bi bi-tags me-1"></i>{{ $item['category_label'] }}</span>
                                @endif
                                @if ($item['color'] === 'couleur')
                                    <span class="text-info-emphasis"><i class="bi bi-palette me-1"></i>Couleur</span>
                                @endif
                            </div>
                        </div>

                        <button type="button" wire:click="remove({{ $index }})" class="btn btn-sm btn-outline-danger flex-shrink-0" title="Retirer cette ligne">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-md-4">
                            <label class="form-label small text-secondary mb-1">Quantité</label>
                            <div class="input-group input-group-sm">
                                <button type="button" wire:click="decrement({{ $index }})" class="btn btn-outline-secondary" @disabled($item['quantity'] <= 1)>
                                    <i class="bi bi-dash"></i>
                                </button>
                                <input type="number" wire:model.live.debounce.400ms="items.{{ $index }}.quantity" min="1" class="form-control text-center">
                                <button type="button" wire:click="increment({{ $index }})" class="btn btn-outline-secondary">
                                    <i class="bi bi-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <label class="form-label small text-secondary mb-1">Prix unitaire</label>
                            <div class="small fw-semibold">
                                {{ number_format($item['unit_price'], 0, ',', ' ') }} Ar
                            </div>
                        </div>

                        <div class="col-6 col-md-2">
                            <label class="form-label small text-secondary mb-1">Remise</label>
                            <div class="input-group input-group-sm">
                                <input type="number" wire:model.live.debounce.400ms="items.{{ $index }}.discount" min="0" max="100" class="form-control text-end">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-3 text-end">
                            <label class="form-label small text-secondary mb-1 d-block">Total ligne</label>
                            @php
                                $lineTotal = $item['unit_price'] * $item['quantity'] * (1 - $item['discount'] / 100);
                            @endphp
                            <span class="fw-semibold text-primary">
                                {{ number_format($lineTotal, 0, ',', ' ') }} Ar
                            </span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Besoins en papier --}}
        @if (count($this->stockRequirements) > 0)
            <div class="border-top mt-4 pt-3">
                <h4 class="small text-uppercase text-secondary fw-bold mb-2" style="font-size: .7rem; letter-spacing: .5px;">
                    Papier nécessaire
                </h4>
                <div class="d-flex flex-column gap-1">
                    @foreach ($this->stockRequirements as $req)
                        <div class="d-flex justify-content-between small">
                            <span class="text-secondary"><i class="bi bi-stack me-1"></i>{{ $req['stock_label'] }}</span>
                            <span class="fw-semibold">{{ $req['required'] }} unités</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Payment & Notes --}}
        <div class="border-top mt-4 pt-3">
            <div class="row g-3">
                <div class="col-12 col-md-5">
                    <label for="paymentMethod" class="form-label small fw-semibold text-secondary">
                        Mode de paiement <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            <i class="bi bi-credit-card text-secondary"></i>
                        </span>
                        <select wire:model.live="paymentMethod" id="paymentMethod" class="form-select border-start-0 @error('payment') is-invalid @enderror">
                            <option value="">— Sélectionner —</option>
                            <option value="espece">Espèces</option>
                            <option value="mvola">MVola</option>
                            <option value="airtel_money">Airtel Money</option>
                            <option value="orange_money">Orange Money</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-7">
                    <label for="note" class="form-label small fw-semibold text-secondary">Note</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            <i class="bi bi-chat-left-text text-secondary"></i>
                        </span>
                        <input type="text" wire:model.live.debounce.400ms="note" id="note" class="form-control border-start-0" placeholder="Ex : Client pressé, à facturer...">
                    </div>
                </div>
            </div>
        </div>

        {{-- Totaux --}}
        <div class="border-top mt-4 pt-3">
            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-secondary">Sous-total</span>
                <span class="fw-semibold">{{ number_format($this->totals['subtotal'], 0, ',', ' ') }} Ar</span>
            </div>

            @if ($this->totals['discount'] > 0)
                <div class="d-flex justify-content-between mb-2 small">
                    <span class="text-secondary">Remises</span>
                    <span class="fw-semibold text-warning-emphasis">
                        - {{ number_format($this->totals['discount'], 0, ',', ' ') }} Ar
                    </span>
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-2">
                <span class="fw-semibold">Total à payer</span>
                <div class="text-end">
                    <span class="fs-4 fw-bold lh-1 text-success">{{ number_format($this->totals['total'], 0, ',', ' ') }}</span>
                    <span class="text-secondary small">Ar</span>
                </div>
            </div>

            {{-- Affichage des Erreurs de stock et globales --}}
            @if (!empty($stockErrors))
                <div class="alert alert-danger d-flex align-items-start mt-3 mb-0" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                    <div>
                        <strong>Stock insuffisant pour finaliser cette vente :</strong>
                        <ul class="mb-0 mt-1 ps-3">
                            @foreach ($stockErrors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-start mt-3 mb-0" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                    <div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Boutons d'action --}}
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button type="button" wire:click="clear" wire:confirm="Voulez-vous vraiment vider tout le panier ?" class="btn btn-sm btn-outline-danger d-flex align-items-center">
                    <i class="bi bi-x-circle me-1"></i>
                    Vider le panier
                </button>

                <div class="d-flex gap-2">
                    <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="button" class="btn btn-primary shadow-sm" wire:click="save" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire:target="save">
                            <i class="bi bi-check-lg me-1"></i>
                            Enregistrer l'activité
                        </span>
                        <span wire:loading wire:target="save">
                            <span class="spinner-border spinner-border-sm me-1"></span>
                            Enregistrement...
                        </span>
                    </button>
                </div>
            </div>
        </div>

    @else
        {{-- Panier vide --}}
        <div class="text-center py-5">
            <i class="bi bi-cart-x text-secondary" style="font-size: 3rem;"></i>
            <p class="text-secondary mb-1 mt-3">Le panier est vide</p>
            <small class="text-secondary">
                Cliquez sur le <strong>+</strong> d'un service pour l'ajouter.
            </small>
        </div>
    @endif
</div>