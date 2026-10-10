@extends('layout')

@section('content')
    <div class="container p-1">

        <!-- En-tête de page -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-receipt text-primary me-2"></i>
                    Activités
                </h1>
                <p class="text-secondary mb-0 small">
                    Enregistrez et consultez vos ventes de services : photocopies, impressions,
                    saisies, tirages photo et autres prestations.
                </p>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('activities.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouvelle activité
                </a>
            </div>
        </div>
        @include('activity.activities_filter')
        @include('activity.activities_table')
    </div>
@endsection
