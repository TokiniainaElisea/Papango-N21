{{-- Modal de création de service --}}
<div class="modal fade" id="createServiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('services.store') }}" method="POST">
                @csrf

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-tools text-primary me-2"></i>
                            Nouveau service
                        </h5>
                        <p class="text-secondary small mb-0">
                            Ajoutez une nouvelle prestation à votre catalogue.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Libellé --}}
                        <div class="col-12">
                            <label for="label" class="form-label small fw-semibold text-secondary">
                                Libellé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tools text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="label"
                                       id="label"
                                       value="{{ old('label') }}"
                                       class="form-control border-start-0 @error('label') is-invalid @enderror"
                                       placeholder="Ex : Photocopie A4 noir"
                                       required>
                                @error('label')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        <div class="col-12 col-md-6">
                            <label for="category_id" class="form-label small fw-semibold text-secondary">
                                Catégorie <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tags text-secondary"></i>
                                </span>
                                <select name="category_id"
                                        id="category_id"
                                        class="form-select border-start-0 @error('category_id') is-invalid @enderror"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Couleur --}}
                        <div class="col-12 col-md-6">
                            <label for="color" class="form-label small fw-semibold text-secondary">
                                Couleur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-palette text-secondary"></i>
                                </span>
                                <select name="color"
                                        id="color"
                                        class="form-select border-start-0 @error('color') is-invalid @enderror"
                                        required>
                                    <option value="noir" @selected(old('color', 'noir') === 'noir')>
                                        Noir & blanc
                                    </option>
                                    <option value="couleur" @selected(old('color') === 'couleur')>
                                        Couleur
                                    </option>
                                    <option value="non-applicable" @selected(old('color') === 'non-applicable')>
                                        Non applicable
                                    </option>
                                </select>
                                @error('color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text small">
                                Choisir "non applicable" pour les services sans notion de couleur (reliure, enveloppe...).
                            </div>
                        </div>

                        {{-- Format --}}
                        <div class="col-12 col-md-6">
                            <label for="format_id" class="form-label small fw-semibold text-secondary">
                                Format <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-aspect-ratio text-secondary"></i>
                                </span>
                                <select name="format_id"
                                        id="format_id"
                                        class="form-select border-start-0 @error('format_id') is-invalid @enderror"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($formats as $format)
                                        <option value="{{ $format->id }}" @selected(old('format_id') == $format->id)>
                                            {{ $format->name }}@if($format->dimension) ({{ $format->dimension }})@endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('format_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Papier (stock) --}}
                        <div class="col-12 col-md-6">
                            <label for="stock_id" class="form-label small fw-semibold text-secondary">
                                Papier consommé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-stack text-secondary"></i>
                                </span>
                                <select name="stock_id"
                                        id="stock_id"
                                        class="form-select border-start-0 @error('stock_id') is-invalid @enderror"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->id }}" @selected(old('stock_id') == $stock->id)>
                                            {{ $stock->label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('stock_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text small">
                                Le stock qui sera décrémenté à chaque vente de ce service.
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="col-12">
                            <label for="price" class="form-label small fw-semibold text-secondary">
                                Prix <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-cash-coin text-secondary"></i>
                                </span>
                                <input type="number"
                                       name="price"
                                       id="price"
                                       value="{{ old('price') }}"
                                       min="0"
                                       step="0.01"
                                       class="form-control border-start-0 @error('price') is-invalid @enderror"
                                       placeholder="Ex : 100"
                                       required>
                                <span class="input-group-text bg-body-tertiary">Ar</span>
                                @error('price')
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