{{-- Tableau des formats --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-body">
                    <tr>
                        <th scope="col" class="ps-3 text-secondary small text-uppercase fw-semibold">Nom</th>
                        <th scope="col" class="text-secondary small text-uppercase fw-semibold">Dimension</th>
                        <th scope="col" class="text-end pe-3 text-secondary small text-uppercase fw-semibold">Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formats as $format)
                        <tr>
                            {{-- Nom du format --}}
                            <td class="ps-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                                        style="width: 36px; height: 36px;">
                                        <i class="bi bi-aspect-ratio small"></i>
                                    </div>
                                    <span class="fw-semibold">{{ $format->name }}</span>
                                </div>
                            </td>

                            {{-- Dimension --}}
                            <td>
                                @if ($format->dimension)
                                    <span class="badge bg-body-tertiary text-body border fw-normal">
                                        {{ $format->dimension }}
                                    </span>
                                @else
                                    <span class="text-secondary">—</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-secondary" title="Modifier"
                                        data-bs-toggle="modal" data-bs-target="#editFormatModal{{ $format->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" title="Supprimer"
                                        data-bs-toggle="modal" data-bs-target="#deleteFormatModal{{ $format->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                            @include('stocks.format.edit_format', ['format' => $format])
                            @include('stocks.format.delete_format', ['format' => $format])
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary d-block mb-2"></i>
                                <p class="text-secondary mb-1">Aucun format enregistré.</p>
                                <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#createFormatModal">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Créer le premier format
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($formats->hasPages())
            <div class="d-flex justify-content-between align-items-center px-3 py-3 border-top">
                <small class="text-secondary">
                    Affichage de
                    <span class="fw-semibold">{{ $formats->firstItem() }}</span>
                    à
                    <span class="fw-semibold">{{ $formats->lastItem() }}</span>
                    sur
                    <span class="fw-semibold">{{ $formats->total() }}</span>
                    formats
                </small>
                <div>
                    {{ $formats->links() }}
                </div>
            </div>
        @endif

    </div>
</div>
