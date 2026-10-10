@extends('layout')

@section('content')
    <div class="container p-1">

    <!-- En-tête de page -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <!-- Titre + description -->
        <div>
            <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                <i class="bi bi-aspect-ratio text-primary me-2"></i>
                Formats
            </h1>
            <p class="text-secondary mb-0 small">
                Gérez les formats de papier disponibles : dimensions, libellés et références.
            </p>
        </div>

        <!-- Actions -->
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i>
                Retour au stock
            </a>
            <button type="button"
                    class="btn btn-primary d-flex align-items-center shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#createFormatModal">
                <i class="bi bi-plus-lg me-1"></i>
                Nouveau format
            </button>
        </div>
    </div>
    @include('stocks.format.new_format')
    @include('stocks.format.format_table')
</div>
@endsection