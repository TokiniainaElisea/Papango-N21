{{-- Modal d'édition de la catégorie #{{ $category->id }} --}}
<div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_editing_id" value="{{ $category->id }}">

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-pencil-square text-primary me-2"></i>
                            Modifier la catégorie
                        </h5>
                        <p class="text-secondary small mb-0">
                            Mettez à jour le nom de la catégorie.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nom --}}
                        <div class="col-12">
                            <label for="edit_label_{{ $category->id }}" class="form-label small fw-semibold text-secondary">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tag text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       id="edit_label_{{ $category->id }}"
                                       value="{{ old('name', $category->name) }}"
                                       class="form-control border-start-0"
                                       required>
                            </div>
                            <div class="form-text small">
                                Exemples : photocopie, impression, saisie, tirage photo...
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Pied --}}
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-lg me-1"></i>
                        Mettre à jour
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>