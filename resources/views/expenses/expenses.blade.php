@extends('layout')

@section('content')
    <div class="container p-1">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

            <!-- Titre + description -->
            <div>
                <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                    <i class="bi bi-cash-stack text-primary me-2"></i>
                    Dépenses
                </h1>
                <p class="text-secondary mb-0 small">
                    Suivez et gérez les dépenses de votre activité.
                </p>
            </div>

            <!-- Actions -->
            <div class="d-flex flex-wrap gap-2">
                <button type="button" class="btn btn-primary d-flex align-items-center shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#createExpenseModal">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nouvelle dépense
                </button>
            </div>

        </div>

        @include('expenses.expenses_filter')
        @include('expenses.expenses_list')
        @include('expenses.new_expense', [
            'id' => 'createExpenseModal',
        ])
    </div>
@endsection
