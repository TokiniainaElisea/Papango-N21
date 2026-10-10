@extends('layout')

@section('content')
    <div class="container p-1">

        <!-- En-tête de page -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-bar-chart-line text-primary me-2"></i>
                    Bilan
                </h1>
                <p class="text-secondary mb-0 small">
                    Analysez vos performances : chiffre d'affaires, marges, services les plus
                    vendus et tendances sur la période sélectionnée.
                </p>
            </div>
        </div>

        {{-- Barre de sélection de période --}}
        <form action="{{ route('bilan.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
            <div class="card-body p-3">

                <div class="d-flex flex-wrap align-items-center gap-3">

                    <span class="text-secondary small fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i>
                        Période :
                    </span>

                    {{-- Date de début --}}
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            Du
                        </span>
                        <input type="date" name="date_from" id="date_from"
                            value="{{ request('date_from', $startDate->format('Y-m-d')) }}"
                            class="form-control border-start-0" required>
                    </div>

                    {{-- Date de fin --}}
                    <div class="input-group input-group-sm" style="width: auto;">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            Au
                        </span>
                        <input type="date" name="date_to" id="date_to"
                            value="{{ request('date_to', $endDate->format('Y-m-d')) }}" class="form-control border-start-0"
                            required>
                    </div>

                    {{-- Bouton appliquer --}}
                    <button type="submit" class="btn btn-sm btn-primary d-flex align-items-center">
                        <i class="bi bi-search me-1"></i>
                        Appliquer
                    </button>

                    {{-- Bouton reset (apparaît si une période est active) --}}
                    @if (request()->hasAny(['date_from', 'date_to']))
                        <a href="{{ route('bilan.index') }}"
                            class="btn btn-sm btn-outline-secondary d-flex align-items-center" title="Réinitialiser">
                            <i class="bi bi-x-lg me-1"></i>
                            Réinitialiser
                        </a>
                    @endif

                </div>

            </div>
        </form>
        @include('bilan.kpis')
        <div class="row mb-4">
            <div class="col-6">
                @include('bilan.average_cart')
            </div>

            <div class="col-6">
                @include('bilan.category_chart')
            </div>
        </div>

        @include('bilan.top_services')
    </div>
@endsection
