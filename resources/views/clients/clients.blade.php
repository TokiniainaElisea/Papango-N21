@extends('layout')

@section('content')
    <div class="container p-1">

        <!-- En-tête de page -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-people-fill text-primary me-2"></i>
                    Clients
                </h1>
                <p class="text-secondary mb-0 small">
                    Gérez votre répertoire client : coordonnées, historique et informations de contact.
                </p>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createClientModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouveau client
                </button>
            </div>
        </div>
        @include('clients.parts.new_client')
        @include('clients.parts.clients_filter')
        @include('clients.parts.clients_table')
    </div>
@endsection
