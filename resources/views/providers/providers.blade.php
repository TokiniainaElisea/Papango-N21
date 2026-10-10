@extends('layout')

@section('content')
    <div class="container p-1">

        <!-- En-tête de page -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-truck text-primary me-2"></i>
                    Fournisseurs
                </h1>
                <p class="text-secondary mb-0 small">
                    Gérez vos partenaires et fournisseurs : coordonnées, contacts et informations commerciales.
                </p>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createProviderModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouveau fournisseur
                </button>
            </div>
        </div>
        @include('providers.parts.new_provider')
        @include('providers.parts.providers_filter')
        @include('providers.parts.providers_table')
    </div>
@endsection
