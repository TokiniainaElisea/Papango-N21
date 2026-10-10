<?php

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Émet un événement pour transmettre le service sélectionné au panier.
     */
    public function addToCart(int $serviceId)
    {
        $service = Service::with(['format', 'stock', 'category'])->findOrFail($serviceId);

        $this->dispatch(
            'service-added',
            service: [
                'id' => $service->id,
                'label' => $service->label,
                'price' => (float) $service->price,
                'color' => $service->color,
                'format_id' => $service->format_id,
                'format_name' => $service->format?->name,
                'stock_id' => $service->stock_id,
                'stock_label' => $service->stock?->label,
                'category_id' => $service->category_id,
                'category_name' => $service->category?->name,
            ],
        );
    }

    public function render()
    {
        $services = Service::query()
            ->with(['format', 'stock', 'category'])
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('label', 'like', "%{$this->search}%")->orWhereHas('category', function ($cat) {
                        $cat->where('label', 'like', "%{$this->search}%");
                    });
                });
            })
            ->orderBy('label')
            ->paginate(10);

        return view('components.activity.service-list', compact('services'));
    }
};
?>

<div>

    {{-- Barre de recherche --}}
    <div class="mb-3">
        <div class="input-group">
            <span class="input-group-text bg-body-tertiary border-end-0">
                <i class="bi bi-search text-secondary"></i>
            </span>
            <input type="text" wire:model.live.debounce.400ms="search" class="form-control border-start-0"
                placeholder="Rechercher un service...">
            @if ($search)
                <button type="button" wire:click="$set('search', '')" class="btn btn-outline-secondary" title="Effacer">
                    <i class="bi bi-x-lg"></i>
                </button>
            @endif
        </div>
        <div wire:loading wire:target="search" class="form-text small">
            <span class="spinner-border spinner-border-sm me-1"></span>
            Recherche...
        </div>
    </div>

    {{-- Liste des services --}}
    <div class="d-flex flex-column gap-2">
        @forelse($services as $service)
            <div wire:key="service-{{ $service->id }}"
                class="border rounded-3 p-3 d-flex justify-content-between align-items-center gap-2">

                {{-- Infos du service --}}
                <div class="flex-grow-1 min-width-0">
                    <div class="d-flex align-items-center gap-1 mb-1">
                        <span class="fw-semibold text-truncate">{{ $service->label }}</span>
                    </div>

                    <div class="d-flex flex-wrap gap-2 small text-secondary">
                        @if ($service->format)
                            <span>
                                <i class="bi bi-aspect-ratio me-1"></i>{{ $service->format->name }}
                            </span>
                        @endif
                        @if ($service->color)
                            <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fw-normal">
                                <i class="bi bi-palette"></i> {{ $service->color }}
                            </span>
                        @endif
                    </div>

                    <div class="fw-semibold text-primary mt-1">
                        {{ number_format($service->price, 0, ',', ' ') }} Ar
                    </div>
                </div>

                {{-- Bouton ajouter --}}
                <button type="button" wire:click="addToCart({{ $service->id }})"
                    class="btn btn-sm btn-primary d-flex align-items-center flex-shrink-0" title="Ajouter au panier">
                    <i class="bi bi-plus-lg"></i>
                </button>

            </div>
        @empty
            <div class="text-center py-4 text-secondary">
                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                @if ($search)
                    Aucun service ne correspond à « {{ $search }} ».
                @else
                    Aucun service disponible.
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if ($services->hasPages())
        <div class="d-flex justify-content-between align-items-center pt-3 mt-2 border-top">
            <small class="text-secondary">
                <span class="fw-semibold">{{ $services->firstItem() }}</span>
                –
                <span class="fw-semibold">{{ $services->lastItem() }}</span>
                sur
                <span class="fw-semibold">{{ $services->total() }}</span>
            </small>
            <div>
                {{ $services->links() }}
            </div>
        </div>
    @endif

</div>
