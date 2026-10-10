@extends('layout')

@section('content')
    <div class="container p-1">
        <div class="container p-1">

            <!-- En-tête de page -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

                <!-- Titre + description -->
                <div>
                    <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                        <i class="bi bi-speedometer2 text-primary me-2"></i>
                        Tableau de bord
                    </h1>
                    <p class="text-secondary mb-0 small">
                        Vue d'ensemble de votre activité : ventes, stock, clients et performances.
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
            @include('home.daily')
            <div class="row mb-4">
                <div class="col-6">
                    @include('home.category_chart')
                </div>

                <div class="col-6">
                    @include('home.ca_chart')
                </div>
            </div>
            @include('home.last_activities')
        </div>
    </div>
@endsection
