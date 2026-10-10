{{-- Modal de création --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-tags text-primary me-2"></i>
                            Nouvelle catégorie
                        </h5>
                        <p class="text-secondary small mb-0">
                            Ajoutez une nouvelle catégorie de service.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nom --}}
                        <div class="col-12">
                            <label for="name" class="form-label small fw-semibold text-secondary">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tag text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       value="{{ old('name') }}"
                                       class="form-control border-start-0 @error('name') is-invalid @enderror"
                                       placeholder="Ex : Photocopie"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                        Enregistrer
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>