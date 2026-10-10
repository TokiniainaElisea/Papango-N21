@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête de la fiche --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('clients.index') }}" class="text-decoration-none">Clients</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $client->firstname }} {{ $client->name }}
                    </li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-person-vcard text-primary me-2"></i>
                Fiche client
            </h1>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
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
                    <span class="fw-semibold fs-4">
                        {{ strtoupper(substr($client->firstname, 0, 1) . substr($client->name, 0, 1)) }}
                    </span>
                </div>
                <div>
                    <h2 class="h4 fw-semibold mb-1">
                        {{ $client->title }} {{ $client->firstname }} {{ $client->name }}
                    </h2>
                    <span class="badge bg-body-tertiary text-body border fw-normal">
                        <i class="bi bi-hash"></i>{{ $client->client_number }}
                    </span>
                </div>
            </div>

            <hr class="text-secondary opacity-25">

            {{-- Bloc coordonnées --}}
            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                style="font-size: .7rem; letter-spacing: .5px;">
                Coordonnées
            </h3>

            <div class="row g-4">

                {{-- Téléphone --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-telephone text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Téléphone</div>
                            <a href="tel:{{ $client->phone }}"
                               class="text-decoration-none link-body-emphasis fw-semibold">
                                {{ $client->phone }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Ville --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-geo-alt text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Ville</div>
                            <div class="fw-semibold">{{ $client->town ?: '—' }}</div>
                        </div>
                    </div>
                </div>

                {{-- Adresse --}}
                <div class="col-12">
                    <div class="d-flex align-items-start">
                        <div class="rounded-3 bg-body-tertiary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-house text-secondary"></i>
                        </div>
                        <div>
                            <div class="text-secondary small">Adresse</div>
                            <div class="fw-semibold">{{ $client->adress ?: '—' }}</div>
                        </div>
                    </div>
                </div>

            </div>

            <hr class="text-secondary opacity-25 my-4">

            {{-- Bloc métadonnées --}}
            <h3 class="h6 text-uppercase text-secondary fw-bold mb-3"
                style="font-size: .7rem; letter-spacing: .5px;">
                Informations
            </h3>

            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="text-secondary small">Créé le</div>
                    <div class="fw-semibold">{{ $client->created_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="text-secondary small">Dernière modification</div>
                    <div class="fw-semibold">{{ $client->updated_at?->format('d/m/Y à H:i') ?? '—' }}</div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection