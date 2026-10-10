@extends('layout')

@section('content')
    <div class="container p-1">

        {{-- En-tête de page --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1 small">
                        <li class="breadcrumb-item">
                            <a href="{{ route('stocks.index') }}" class="text-decoration-none">Stock</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('stocks.show', $stock) }}" class="text-decoration-none">
                                {{ $stock->label }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Mouvements</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                    <i class="bi bi-sliders text-primary me-2"></i>
                    Mouvements de stock
                </h1>
                <p class="text-secondary mb-0 small">
                    Historique des entrées et sorties pour
                    <strong>{{ $stock->label }}</strong>.
                </p>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('stocks.show', $stock) }}" class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="bi bi-arrow-left me-1"></i>
                    Retour à la fiche
                </a>
                <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createMovementModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouveau mouvement
                </button>
            </div>
        </div>

        {{-- Carte : résumé du stock --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row g-3 align-items-center">

                    {{-- Stock actuel --}}
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 {{ $totalStock > 0 ? 'bg-success-subtle text-success-emphasis' : 'bg-danger-subtle text-danger-emphasis' }} d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-box-seam fs-5"></i>
                            </div>
                            <div>
                                <div class="text-secondary small">Stock actuel</div>
                                <div class="fs-5 fw-bold lh-1">
                                    @if ($totalStock > 0)
                                        {{ number_format($totalStock, 0, ',', ' ') }} unités
                                    @else
                                        Rupture
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Nombre de mouvements --}}
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-list-ul fs-5 text-secondary"></i>
                            </div>
                            <div>
                                <div class="text-secondary small">Mouvements</div>
                                <div class="fs-5 fw-bold lh-1">
                                    {{ $totalCount }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Dernier prix fournisseur --}}
                    <div class="col-12 col-md-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                style="width: 48px; height: 48px;">
                                <i class="bi bi-cash-coin fs-5 text-secondary"></i>
                            </div>
                            <div>
                                <div class="text-secondary small">Dernier prix fournisseur</div>
                                <div class="fs-5 fw-bold lh-1">
                                    {{ $lastPrice ? number_format($lastPrice, 0, ',', ' ') . ' Ar' : '—' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Tableau des mouvements --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-body">
                            <tr>
                                <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Date</th>
                                <th scope="col" class="text-secondary small text-uppercase fw-semibold">Type</th>
                                <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Stock
                                    initial</th>
                                <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Stock
                                    actuel</th>
                                <th scope="col" class="text-end text-secondary small text-uppercase fw-semibold">Prix
                                    fournisseur</th>
                                <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $movement)
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
                                        @if ($movement->movement_type === 'entry')
                                            <span
                                                class="badge bg-success-subtle text-success-emphasis border border-success-subtle">
                                                <i class="bi bi-arrow-down-circle me-1"></i>Entrée
                                            </span>
                                        @elseif($movement->movement_type === 'exit')
                                            <span
                                                class="badge bg-danger-subtle text-danger-emphasis border border-danger-subtle">
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
                                    <td class="text-end">
                                        {{ number_format($movement->provider_price, 0, ',', ' ') }} Ar
                                    </td>

                                    {{-- Actions --}}
                                    {{-- Actions --}}
                                    <td class="text-end pe-3">
                                        @if ($movement->id === $lastMovementId)
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                title="Supprimer ce mouvement" data-bs-toggle="modal"
                                                data-bs-target="#deleteMovementModal{{ $movement->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-outline-secondary" disabled
                                                title="Seul le dernier mouvement peut être supprimé">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        @endif
                                    </td>
                                    @include('stocks.movement.delete_movement', ['movement' => $movement])
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                        <p class="text-secondary mb-1">Aucun mouvement enregistré.</p>
                                        <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                            data-bs-target="#createMovementModal">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Créer le premier mouvement
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($movements->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                        <small class="text-secondary">
                            Affichage de
                            <span class="fw-semibold">{{ $movements->firstItem() }}</span>
                            à
                            <span class="fw-semibold">{{ $movements->lastItem() }}</span>
                            sur
                            <span class="fw-semibold">{{ $movements->total() }}</span>
                            mouvements
                        </small>
                        <div>
                            {{ $movements->links() }}
                        </div>
                    </div>
                @endif

            </div>
        </div>
        @include('stocks.movement.new_movement')
    </div>
@endsection
