@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête de la fiche --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('services.index') }}" class="text-decoration-none">Services</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $service->label }}
                    </li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-tools text-primary me-2"></i>
                Fiche service
            </h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- Colonne principale : infos du service --}}
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">

                    {{-- Bloc identité --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle {{ $service->color === 'couleur' ? 'bg-info-subtle text-info-emphasis' : 'bg-primary-subtle text-primary' }} d-flex align-items-center justify-content-center me-3"
                             style="width: 72px; height: 72px;">
                            <i class="bi bi-tools fs-3"></i>
                        </div>
                        <div>
                            <h2 class="h4 fw-semibold mb-1">
                                {{ $service->label }}
                            </h2>
                            <div class="d-flex flex-wrap gap-1">
                                @if($service->category)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-tags me-1"></i>{{ $service->category->name }}
                                    </span>
                                @endif

                                @if($service->color === 'couleur')
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle">
                                        <i class="bi bi-palette me-1"></i>Couleur
                                    </span>
                                @elseif($service->color === 'non-applicable')
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-dash-circle me-1"></i>Non applicable
                                    </span>
                                @else
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        <i class="bi bi-circle-half me-1"></i>Noir & blanc
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

                        {{-- Catégorie --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-tags text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Catégorie</div>
                                    <div class="fw-semibold">{{ $service->category?->name ?? '—' }}</div>
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
                                        {{ $service->format?->name ?? '—' }}
                                        @if($service->format?->dimension)
                                            <span class="text-secondary small">({{ $service->format->dimension }})</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Papier consommé --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-stack text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Papier consommé</div>
                                    @if($service->stock)
                                        <a href="{{ route('stocks.show', $service->stock) }}"
                                           class="text-decoration-none link-body-emphasis fw-semibold">
                                            {{ $service->stock->label }}
                                        </a>
                                    @else
                                        <div class="fw-semibold">—</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Couleur --}}
                        <div class="col-12 col-md-6">
                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 40px; height: 40px;">
                                    <i class="bi bi-palette text-secondary"></i>
                                </div>
                                <div>
                                    <div class="text-secondary small">Couleur</div>
                                    <div class="fw-semibold">
                                        @if($service->color === 'couleur')
                                            Couleur
                                        @elseif($service->color === 'non-applicable')
                                            Non applicable
                                        @else
                                            Noir & blanc
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <hr class="text-secondary opacity-25 my-4">

                    {{-- Section Informations --}}
                    <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                        style="font-size: .7rem; letter-spacing: .5px;">
                        Informations
                    </h3>

                    <div class="row g-4">
                        <div class="col-12 col-md-6">
                            <div class="text-secondary small">Créé le</div>
                            <div class="fw-semibold">{{ $service->created_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="text-secondary small">Dernière modification</div>
                            <div class="fw-semibold">{{ $service->updated_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Colonne secondaire : prix --}}
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column">

                    <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                        style="font-size: .7rem; letter-spacing: .5px;">
                        Tarif
                    </h3>

                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-3 bg-success-subtle text-success-emphasis d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 56px; height: 56px;">
                            <i class="bi bi-cash-coin fs-4"></i>
                        </div>
                        <div>
                            <div class="fs-3 fw-bold lh-1">
                                {{ number_format($service->price, 0, ',', ' ') }}
                            </div>
                            <div class="text-secondary small">Ariary par unité</div>
                        </div>
                    </div>

                    <hr class="text-secondary opacity-25">

                    {{-- Note informative --}}
                    <div class="alert alert-info d-flex align-items-start mb-0 mt-auto" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            Ce prix est le tarif <strong>actuel</strong>. Les ventes déjà
                            enregistrées conservent le prix appliqué au moment de la vente.
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>
@endsection