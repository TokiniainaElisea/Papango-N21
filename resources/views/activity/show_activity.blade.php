@extends('layout')

@section('content')
    <div class="container p-1">

        {{-- En-tête de la fiche --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item">
                            <a href="{{ route('activities.index') }}" class="text-decoration-none">Activités</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            {{ $activity->ref }}
                        </li>
                    </ol>
                </nav>
                <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                    <i class="bi bi-receipt text-primary me-2"></i>
                    Activité {{ $activity->ref }}
                </h1>
                <p class="text-secondary mb-0 small">
                    Enregistrée le
                    <strong>{{ \Carbon\Carbon::parse($activity->sold_at)->format('d/m/Y') }}</strong>
                    à
                    {{ $activity->created_at?->format('H:i') ?? '—' }}.
                </p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour
                </a>
                <a href="{{ route('activities.print', $activity) }}"
                    class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-printer me-1"></i>
                    Imprimer
                </a>
            </div>
        </div>

        <div class="row g-4">

            {{-- ============================================================ --}}
            {{-- COLONNE PRINCIPALE --}}
            {{-- ============================================================ --}}
            <div class="col-12 col-lg-8">

                {{-- Carte : lignes de la vente --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-0">

                        <div class="p-4 pb-3 d-flex justify-content-between align-items-center">
                            <h3 class="h6 text-uppercase text-secondary fw-bold mb-0"
                                style="font-size: .7rem; letter-spacing: .5px;">
                                <i class="bi bi-tools me-1"></i>
                                Détail des prestations
                            </h3>
                            <span class="badge bg-body-tertiary text-body border fw-normal">
                                {{ $activity->details->count() }} ligne(s)
                            </span>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-body">
                                    <tr>
                                        <th scope="col" class="ps-4 text-secondary small text-uppercase fw-semibold">
                                            Service</th>
                                        <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">
                                            Prix unit.</th>
                                        <th scope="col"
                                            class="text-center text-secondary small text-uppercase fw-semibold">Qté</th>
                                        <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">
                                            Remise</th>
                                        <th scope="col"
                                            class="text-end pe-4 text-secondary small text-uppercase fw-semibold">Total
                                            ligne</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activity->details as $detail)
                                        <tr>
                                            {{-- Service --}}
                                            <td class="ps-4">
                                                <div class="fw-semibold">{{ $detail->service_label }}</div>
                                                @if ($detail->service)
                                                    <div class="small">
                                                        <a href="{{ route('services.show', $detail->service) }}"
                                                            class="text-decoration-none link-secondary">
                                                            <i class="bi bi-box-arrow-up-right me-1"></i>
                                                            Voir le service
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="small text-secondary">
                                                        <i class="bi bi-info-circle me-1"></i>
                                                        Service supprimé
                                                    </div>
                                                @endif
                                            </td>

                                            {{-- Prix unitaire --}}
                                            <td class="text-end">
                                                {{ number_format($detail->unit_price, 0, ',', ' ') }} Ar
                                            </td>

                                            {{-- Quantité --}}
                                            <td class="text-center">
                                                <span class="badge bg-body-tertiary text-body border fw-normal">
                                                    {{ $detail->quantity }}
                                                </span>
                                            </td>

                                            {{-- Remise --}}
                                            <td class="text-end">
                                                @if ($detail->discount > 0)
                                                    <span
                                                        class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                                                        -{{ number_format($detail->discount, 0, ',', ' ') }}%
                                                    </span>
                                                @else
                                                    <span class="text-secondary">—</span>
                                                @endif
                                            </td>

                                            {{-- Total ligne --}}
                                            <td class="text-end pe-4 fw-semibold">
                                                {{ number_format($detail->total_line, 0, ',', ' ') }} Ar
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-secondary">
                                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                                Aucune ligne enregistrée.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                {{-- Carte : papier consommé --}}
                @php
                    // Agrégation des besoins en papier par stock (déduits des services)
                    $paperConsumption = [];
                    foreach ($activity->details as $detail) {
                        $stock = $detail->service?->stock;
                        if (!$stock) {
                            continue;
                        }

                        $stockId = $stock->id;
                        if (!isset($paperConsumption[$stockId])) {
                            $paperConsumption[$stockId] = [
                                'label' => $stock->label,
                                'format' => $stock->format?->name,
                                'quantity' => 0,
                            ];
                        }
                        $paperConsumption[$stockId]['quantity'] += $detail->quantity;
                    }
                @endphp

                @if (count($paperConsumption) > 0)
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">

                            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                                style="font-size: .7rem; letter-spacing: .5px;">
                                <i class="bi bi-stack me-1"></i>
                                Papier consommé
                            </h3>

                            <div class="row g-3">
                                @foreach ($paperConsumption as $paper)
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                                style="width: 40px; height: 40px;">
                                                <i class="bi bi-stack text-secondary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $paper['label'] }}</div>
                                                <div class="text-secondary small">
                                                    @if ($paper['format'])
                                                        <i class="bi bi-aspect-ratio me-1"></i>{{ $paper['format'] }}
                                                        <span class="mx-1">·</span>
                                                    @endif
                                                    <strong>{{ $paper['quantity'] }}</strong> unité(s)
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                @endif

                {{-- Carte : note --}}
                @if ($activity->note)
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                                style="font-size: .7rem; letter-spacing: .5px;">
                                <i class="bi bi-chat-left-text me-1"></i>
                                Note
                            </h3>
                            <p class="mb-0 small" style="white-space: pre-line;">{{ $activity->note }}</p>
                        </div>
                    </div>
                @endif

            </div>

            {{-- ============================================================ --}}
            {{-- COLONNE LATÉRALE --}}
            {{-- ============================================================ --}}
            <div class="col-12 col-lg-4">

                {{-- Carte : client --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-person-vcard me-1"></i>
                            Client
                        </h3>

                        @if ($activity->client)
                            <div class="d-flex align-items-start mb-3">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                    style="width: 48px; height: 48px;">
                                    <span class="fw-semibold">
                                        {{ strtoupper(substr($activity->client->firstname, 0, 1) . substr($activity->client->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="fw-semibold">
                                        {{ $activity->client->title }}
                                        {{ $activity->client->firstname }}
                                        {{ $activity->client->name }}
                                    </div>
                                    <span class="badge bg-body-tertiary text-body border fw-normal mt-1">
                                        <i class="bi bi-hash"></i>{{ $activity->client->client_number }}
                                    </span>
                                </div>
                            </div>

                            <hr class="text-secondary opacity-25">

                            <div class="d-flex flex-column gap-2 small">
                                @if ($activity->client->phone)
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone text-secondary me-2"></i>
                                        <a href="tel:{{ $activity->client->phone }}"
                                            class="text-decoration-none link-body-emphasis">
                                            {{ $activity->client->phone }}
                                        </a>
                                    </div>
                                @endif

                                @if ($activity->client->town)
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-geo-alt text-secondary me-2"></i>
                                        {{ $activity->client->town }}
                                    </div>
                                @endif

                                @if ($activity->client->adress)
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-house text-secondary me-2 mt-1"></i>
                                        <span>{{ $activity->client->adress }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-3 pt-3 border-top">
                                <a href="{{ route('clients.show', $activity->client) }}"
                                    class="text-decoration-none small">
                                    Voir la fiche client →
                                </a>
                            </div>
                        @else
                            <div class="d-flex align-items-center text-secondary">
                                <div class="rounded-circle bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                    style="width: 48px; height: 48px;">
                                    <i class="bi bi-person-dash"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold">Client de passage</div>
                                    <div class="small">Aucun client enregistré.</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Carte : mode de paiement --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-credit-card me-1"></i>
                            Mode de paiement
                        </h3>

                        @php
                            $paymentLabels = [
                                'espece' => ['label' => 'Espèces', 'icon' => 'bi-cash-stack'],
                                'mvola' => ['label' => 'MVola', 'icon' => 'bi-phone'],
                                'airtel_money' => ['label' => 'Airtel Money', 'icon' => 'bi-phone'],
                                'orange_money' => ['label' => 'Orange Money', 'icon' => 'bi-phone'],
                            ];
                            $payment = $paymentLabels[$activity->payment_method] ?? null;
                        @endphp

                        @if ($payment)
                            <div class="d-flex align-items-center">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                    style="width: 40px; height: 40px;">
                                    <i class="bi {{ $payment['icon'] }} text-secondary"></i>
                                </div>
                                <span class="fw-semibold">{{ $payment['label'] }}</span>
                            </div>
                        @else
                            <span class="text-secondary">—</span>
                        @endif
                    </div>
                </div>

                {{-- Carte : récapitulatif --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-calculator me-1"></i>
                            Récapitulatif
                        </h3>

                        {{-- Stats --}}
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-secondary">Nombre de lignes</span>
                            <span class="fw-semibold">{{ $activity->details->count() }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-3 small">
                            <span class="text-secondary">Articles vendus</span>
                            <span class="fw-semibold">{{ $activity->details->sum('quantity') }}</span>
                        </div>

                        <hr class="text-secondary opacity-25">

                        {{-- Sous-total --}}
                        @php
                            $subtotal = $activity->details->sum(function ($d) {
                                return $d->unit_price * $d->quantity;
                            });
                            $totalDiscount = $subtotal - $activity->total_price;
                        @endphp

                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-secondary">Sous-total</span>
                            <span class="fw-semibold">
                                {{ number_format($subtotal, 0, ',', ' ') }} Ar
                            </span>
                        </div>

                        @if ($totalDiscount > 0)
                            <div class="d-flex justify-content-between mb-2 small">
                                <span class="text-secondary">Remises</span>
                                <span class="fw-semibold text-warning-emphasis">
                                    - {{ number_format($totalDiscount, 0, ',', ' ') }} Ar
                                </span>
                            </div>
                        @endif

                        <hr class="text-secondary opacity-25">

                        {{-- Total --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Total</span>
                            <div class="text-end">
                                <span class="fs-4 fw-bold lh-1 text-success">
                                    {{ number_format($activity->total_price, 0, ',', ' ') }}
                                </span>
                                <span class="text-secondary small">Ar</span>
                            </div>
                        </div>

                        {{-- Marge --}}
                        @php
                            $totalCost = $activity->details->sum('cost_price');
                            $margin = $activity->total_price - $totalCost;
                        @endphp
                        @if ($totalCost > 0)
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between small mb-1">
                                    <span class="text-secondary">Coût fournisseur</span>
                                    <span class="fw-semibold text-secondary">
                                        {{ number_format($totalCost, 0, ',', ' ') }} Ar
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between small">
                                    <span class="text-secondary">Marge brute</span>
                                    <span
                                        class="fw-semibold {{ $margin >= 0 ? 'text-success-emphasis' : 'text-danger-emphasis' }}">
                                        {{ number_format($margin, 0, ',', ' ') }} Ar
                                    </span>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection
