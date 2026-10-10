@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête de page --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

        {{-- Titre + description --}}
        <div>
            <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                <i class="bi bi-tags text-primary me-2"></i>
                Catégories
            </h1>
            <p class="text-secondary mb-0 small">
                Gérez les catégories de services : photocopie, impression, saisie, tirage photo, etc.
            </p>
        </div>

        {{-- Actions --}}
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('services.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                <i class="bi bi-arrow-left me-1"></i>
                Retour aux services
            </a>
            <button type="button"
                    class="btn btn-primary d-flex align-items-center shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#createCategoryModal">
                <i class="bi bi-plus-lg me-1"></i>
                Nouvelle catégorie
            </button>
        </div>
    </div>

    {{-- Tableau --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-body">
                        <tr>
                            <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Nom</th>
                            <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                {{-- Nom --}}
                                <td class="ps-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                             style="width: 36px; height: 36px;">
                                            <i class="bi bi-tag small"></i>
                                        </div>
                                        <span class="fw-semibold">{{ $category->name }}</span>
                                    </div>
                                </td>

                                {{-- Actions --}}
                                <td class="text-end pe-3">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button"
                                                class="btn btn-secondary"
                                                title="Modifier"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editCategoryModal{{ $category->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button"
                                                class="btn btn-danger"
                                                title="Supprimer"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteCategoryModal{{ $category->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                                @include('service.category.edit_category', ['category' => $category])
                                @include('service.category.delete_category', ['category' => $category])
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                    <p class="text-secondary mb-1">Aucune catégorie enregistrée.</p>
                                    <button type="button"
                                            class="btn btn-sm btn-primary mt-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#createCategoryModal">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Créer la première catégorie
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($categories->hasPages())
                <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                    <small class="text-secondary">
                        Affichage de
                        <span class="fw-semibold">{{ $categories->firstItem() }}</span>
                        à
                        <span class="fw-semibold">{{ $categories->lastItem() }}</span>
                        sur
                        <span class="fw-semibold">{{ $categories->total() }}</span>
                        catégories
                    </small>
                    <div>
                        {{ $categories->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>

</div>

{{-- Modals --}}
@include('service.category.new_category')

@endsection