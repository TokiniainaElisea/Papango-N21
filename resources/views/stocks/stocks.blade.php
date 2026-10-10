@extends('layout')

@section('content')
    <div class="container p-1">

        <!-- En-tête de page -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-stack text-primary me-2"></i>
                    Stock
                </h1>
                <p class="text-secondary mb-0 small">
                    Gérez votre catalogue de papiers : références, formats, types et niveaux de stock.
                </p>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2">

                <!-- Gestion : Formats + Types -->
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-gear me-1"></i>
                        Paramètres
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('formats.index') }}">
                                <i class="bi bi-aspect-ratio text-secondary me-2"></i>
                                Formats
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('types.index') }}">
                                <i class="bi bi-tags text-secondary me-2"></i>
                                Types de papier
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Action principale -->
                <a href="{{ route('stocks.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouveau
                </a>

            </div>
        </div>

        @include('stocks.stocks_filter')

        @include('stocks.stocks_table')

    </div>
@endsection
