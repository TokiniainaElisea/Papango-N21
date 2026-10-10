{{-- Tableau des types de papier --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Nom</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paperTypes as $type)
                        <tr>
                            {{-- Nom du type --}}
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                        style="width: 36px; height: 36px;">
                                        <i class="bi bi-tag small"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $type->name }}</span>
                                </div>
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-secondary" title="Modifier"
                                        data-bs-toggle="modal" data-bs-target="#editPaperTypeModal{{ $type->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Supprimer"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deletePaperTypeModal{{ $type->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @include('stocks.type.edit_type', ['type' => $type])
                            @include('stocks.type.delete_type', ['type' => $type])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun type de papier enregistré.</p>
                                <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#createPaperTypeModal">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Créer le premier type
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($paperTypes->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $paperTypes->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $paperTypes->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $paperTypes->total() }}</span>
                    types
                </small>
                <div>
                    {{ $paperTypes->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
