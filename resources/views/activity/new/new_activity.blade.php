@extends('layout')

@section('content')
    <div class="container p-1">

    <!-- En-tête de page -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        <!-- Titre + description -->
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('activities.index') }}" class="text-decoration-none">Activités</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Nouvelle activité</li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-receipt text-primary me-2"></i>
                Nouvelle activité
            </h1>
            <p class="text-secondary mb-0 small">
                Enregistrez une vente de services : sélectionnez un client, ajoutez les
                prestations effectuées, appliquez les remises éventuelles.
            </p>
        </div>

        <a href="{{ route('activities.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>
    </div>

    <livewire:activity.activity-page />

</div>
@endsection