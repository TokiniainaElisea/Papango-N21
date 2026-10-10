@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête de la fiche --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('stocks.index') }}" class="text-decoration-none">Stock</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $stock->label }}
                    </li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-stack text-primary me-2"></i>
                Fiche 
            </h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
            <a href="{{ route('stocks.edit', $stock) }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                <i class="bi bi-pencil me-1"></i>
                Modifier
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Colonne principale --}}
        <div class="col-12 col-lg-7">

            {{-- Carte identité + infos --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    {{-- Bloc identité --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                             style="width: 72px; height: 72px;">
                            <i class="bi bi-stack fs-3"></i>
                        </div>
                        <div>
                            <h2 class="h4 fw-semibold mb-1">
                                {{ $stock->label }}
                            </h2>
                            <div class="d-flex flex-wrap gap-1">
                                @if($stock->type)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-tags me-1"></i>{{ $stock->type->name }}
                                    </span>
                                @endif
                                @if($stock->format)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-aspect-ratio me-1"></i>{{ $stock->format->name }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25">

                    {{-- Section Détails --}}
                    <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                        style="font-size: .7rem; letter-spacing: .5px;">
                        Détails
                    </h3>

                    <div class="row g-4">

                        {{-- Type de papier --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-tags text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Type de papier</div>
                                    <div class="fw-semibold">{{ $stock->type?->name ?? '—' }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Format --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-aspect-ratio text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Format</div>
                                    <div class="fw-semibold">
                                        {{ $stock->format?->name ?? '—' }}
                                        @if($stock->format?->dimension)
                                            <span class="text-secondary small">({{ $stock->format->dimension }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Fournisseur --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-truck text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Fournisseur</div>
                                    @if($stock->provider)
                                        <a href="{{ route('providers.show', $stock->provider) }}"
                                           class="text-decoration-none link-body-emphasis fw-semibold">
                                            {{ $stock->provider->name_provider }}
                                        </a>
                                    @else
                                        <div class="fw-semibold">—</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Date de création --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-calendar-event text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Ajouté le</div>
                                    <div class="fw-semibold">
                                        {{ $stock->created_at?->format('d/m/Y à H:i') ?? '—' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- Colonne secondaire : stock actuel --}}
        <div class="col-12 col-lg-5">

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">

                    <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                        style="font-size: .7rem; letter-spacing: .5px;">
                        Stock actuel
                    </h3>

                    @php
                        $totalStock = $stock->stock_movement->sum('in_stock');
                    @endphp

                    <div class="d-flex align-items-center">
                        @if($totalStock > 0)
                            <div class="rounded-3 bg-success-subtle text-success-emphasis d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                 style="width: 56px; height: 56px;">
                                <i class="bi bi-box-seam fs-4"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-bold lh-1">
                                    {{ number_format($totalStock, 0, ',', ' ') }}
                                </div>
                                <div class="text-secondary small">unités en stock</div>
                            </div>
                        @else
                            <div class="rounded-3 bg-danger-subtle text-danger-emphasis d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                 style="width: 56px; height: 56px;">
                                <i class="bi bi-exclamation-triangle fs-4"></i>
                            </div>
                            <div>
                                <div class="fs-3 fw-bold lh-1 text-danger">Rupture</div>
                                <div class="text-secondary small">aucune unité disponible</div>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>

        {{-- Section Mouvements (pleine largeur) --}}
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    {{-- Titre + bouton gérer --}}
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h3 class="h6 text-uppercase text-secondary fw-bold mb-0"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            Mouvements de stock
                        </h3>

                        <a href="{{ route('stocks-movement.index', $stock) }}"
                           class="btn btn-sm btn-outline-primary d-flex align-items-center">
                            <i class="bi bi-sliders me-1"></i>
                            Gérer les mouvements
                        </a>
                    </div>

                    {{-- Tableau des mouvements --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-body">
                                <tr>
                                    <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Date</th>
                                    <th scope="col" class="text-secondary small text-uppercase fw-semibold">Type</th>
                                    <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Stock initial</th>
                                    <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Stock actuel</th>
                                    <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Prix fournisseur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stock_movement as $movement)
                                    <tr>
                                        {{-- Date --}}
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-calendar-event text-secondary me-2"></i>
                                                <span>{{ \Carbon\Carbon::parse($movement->entry_stock)->format('d/m/Y') }}</span>
                                            </div>
                                        </td>

                                        {{-- Type --}}
                                        <td>
                                            @if($movement->movement_type === 'entry')
                                                <span class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                                    <i class="bi bi-arrow-down-circle me-1"></i>Entrée
                                                </span>
                                            @elseif($movement->movement_type === 'exit')
                                                <span class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">
                                                    <i class="bi bi-arrow-up-circle me-1"></i>Sortie
                                                </span>
                                            @else
                                                <span class="badge bg-body-tertiary text-body border">
                                                    {{ $movement->movement_type }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Stock initial --}}
                                        <td class="text-end">
                                            {{ number_format($movement->initial_stock, 0, ',', ' ') }}
                                        </td>

                                        {{-- Stock actuel --}}
                                        <td class="text-end fw-semibold">
                                            {{ number_format($movement->in_stock, 0, ',', ' ') }}
                                        </td>

                                        {{-- Prix fournisseur --}}
                                        <td class="text-end pe-3">
                                            {{ number_format($movement->provider_price, 0, ',', ' ') }} Ar
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-secondary">
                                            <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                            Aucun mouvement enregistré.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                            {{ $stock_movement->links() }}
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection