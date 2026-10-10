@extends('layout')

@section('content')
    <div class="container p-1">

    <!-- En-tête de page -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <!-- Titre + description -->
        <div>
            <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                <i class="bi bi-tools text-primary me-2"></i>
                Services
            </h1>
            <p class="text-secondary mb-0 small">
                Gérez vos prestations : photocopies, impressions, saisie, tirages photo
                et autres services proposés à vos clients.
            </p>
        </div>

        <!-- Actions -->
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-tags me-1"></i>
                Catégories
            </a>
            <button type="button"
                    class="btn btn-primary d-flex align-items-center shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#createServiceModal">
                <i class="bi bi-plus-lg me-1"></i>
                Nouveau service
            </button>
        </div>
    </div>
    @include('service.new_service')
    @include('service.services_filter')
    @include('service.services_table')
</div>
@endsection