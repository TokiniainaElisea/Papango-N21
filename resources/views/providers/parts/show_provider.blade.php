@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête de la fiche --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('providers.index') }}" class="text-decoration-none">Fournisseurs</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $provider->name_provider }}
                    </li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-truck text-primary me-2"></i>
                Fiche fournisseur
            </h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('providers.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i>
                Retour
            </a>
        </div>
    </div>

    {{-- Carte principale --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- Bloc identité --}}
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3"
                     style="width: 72px; height: 72px;">
                    <i class="bi bi-truck fs-3"></i>
                </div>
                <div>
                    <h2 class="h4 fw-semibold mb-1">
                        {{ $provider->name_provider }}
                    </h2>
                    @if($provider->name_contact)
                        <span class="badge bg-body-tertiary text-body border fw-normal">
                            <i class="bi bi-person me-1"></i>{{ $provider->name_contact }}
                        </span>
                    @endif
                </div>
            </div>

            <hr class="text-secondary opacity-25">

            {{-- Bloc coordonnées --}}
            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                style="font-size: .7rem; letter-spacing: .5px;">
                Coordonnées
            </h3>

            <div class="row g-4">

                {{-- Email --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-envelope text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Email</div>
                            @if($provider->mail)
                                <a href="mailto:{{ $provider->mail }}"
                                   class="text-decoration-none link-body-emphasis fw-semibold">
                                    {{ $provider->mail }}
                                </a>
                            @else
                                <div class="fw-semibold">—</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Téléphone --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-telephone text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Téléphone</div>
                            @if($provider->phone)
                                <a href="tel:{{ $provider->phone }}"
                                   class="text-decoration-none link-body-emphasis fw-semibold">
                                    {{ $provider->phone }}
                                </a>
                            @else
                                <div class="fw-semibold">—</div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Adresse --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-house text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Adresse</div>
                            <div class="fw-semibold">{{ $provider->adress ?: '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Ville + Pays --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Localisation</div>
                            <div class="fw-semibold">
                                {{ $provider->town ?: '—' }}@if($provider->country), {{ $provider->country }}@endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Bloc contact --}}
            @if($provider->name_contact)
                <hr class="text-secondary opacity-25 my-4">

                <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                    style="font-size: .7rem; letter-spacing: .5px;">
                    Contact
                </h3>

                <div class="d-flex align-items-start">
                    <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-person text-secondary"></i>
                    </div>
                    <div>
                        <div class="text-secondary small">Personne référente</div>
                        <div class="fw-semibold">{{ $provider->name_contact }}</div>
                    </div>
                </div>
            @endif

            {{-- Bloc note --}}
            @if($provider->note)
                <hr class="text-secondary opacity-25 my-4">

                <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                    style="font-size: .7rem; letter-spacing: .5px;">
                    Note
                </h3>

                <div class="bg-body-tertiary rounded-3 p-3">
                    <p class="mb-0 small" style="white-space: pre-line;">{{ $provider->note }}</p>
                </div>
            @endif

            <hr class="text-secondary opacity-25 my-4">

            {{-- Bloc métadonnées --}}
            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                style="font-size: .7rem; letter-spacing: .5px;">
                Informations
            </h3>

            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="text-secondary small">Créé le</div>
                    <div class="fw-semibold">{{ $provider->created_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="text-secondary small">Dernière modification</div>
                    <div class="fw-semibold">{{ $provider->updated_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection