{{-- Modal de création de mouvement --}}
<div class="modal fade" id="createMovementModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="stock_id" value="{{ $stock->id }}">

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-plus-circle text-primary me-2"></i>
                            Nouveau mouvement
                        </h5>
                        <p class="text-secondary small mb-0">
                            Enregistrez une entrée ou une sortie de stock pour
                            <strong>{{ $stock->label }}</strong>.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Type de mouvement --}}
                        <div class="col-12">
                            <label class="form-label small fw-semibold text-secondary d-block">
                                Type de mouvement <span class="text-danger">*</span>
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio"
                                       class="btn-check"
                                       name="movement_type"
                                       id="movement_type_entry"
                                       value="entry"
                                       @checked(old('movement_type', 'entry') === 'entry')
                                       required>
                                <label class="btn btn-outline-success d-flex align-items-center justify-content-center" for="movement_type_entry">
                                    <i class="bi bi-arrow-down-circle me-1"></i>
                                    Entrée
                                </label>

                                <input type="radio"
                                       class="btn-check"
                                       name="movement_type"
                                       id="movement_type_exit"
                                       value="exit"
                                       @checked(old('movement_type') === 'exit')>
                                <label class="btn btn-outline-danger d-flex align-items-center justify-content-center" for="movement_type_exit">
                                    <i class="bi bi-arrow-up-circle me-1"></i>
                                    Sortie
                                </label>
                            </div>
                            @error('movement_type')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Quantité --}}
                        <div class="col-12">
                            <label for="initial_stock" class="form-label small fw-semibold text-secondary">
                                Quantité <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-box-seam text-secondary"></i>
                                </span>
                                <input type="number"
                                       name="initial_stock"
                                       id="initial_stock"
                                       value="{{ old('initial_stock') }}"
                                       min="1"
                                       class="form-control border-start-0 @error('initial_stock') is-invalid @enderror"
                                       placeholder="Ex : 500"
                                       required>
                                @error('initial_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text small">
                                Toujours une valeur positive. Le sens est déterminé par le type.
                            </div>
                        </div>

                        {{-- Prix fournisseur --}}
                        <div class="col-12">
                            <label for="provider_price" class="form-label small fw-semibold text-secondary">
                                Prix fournisseur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-cash-coin text-secondary"></i>
                                </span>
                                <input type="number"
                                       name="provider_price"
                                       id="provider_price"
                                       value="{{ old('provider_price') }}"
                                       min="0"
                                       step="0.01"
                                       class="form-control border-start-0 @error('provider_price') is-invalid @enderror"
                                       placeholder="Ex : 15000"
                                       required>
                                <span class="input-group-text bg-body-tertiary">Ar</span>
                                @error('provider_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Date d'entrée --}}
                        <div class="col-12">
                            <label for="entry_stock" class="form-label small fw-semibold text-secondary">
                                Date du mouvement <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-calendar-event text-secondary"></i>
                                </span>
                                <input type="date"
                                       name="entry_stock"
                                       id="entry_stock"
                                       value="{{ old('entry_stock', now()->format('Y-m-d')) }}"
                                       class="form-control border-start-0 @error('entry_stock') is-invalid @enderror"
                                       required>
                                @error('entry_stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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