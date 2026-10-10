<div class="modal fade" id="editServiceModal{{ $service->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('services.update', $service) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="_editing_id" value="{{ $service->id }}">

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-pencil-square text-primary me-2"></i>
                            Modifier le service
                        </h5>
                        <p class="text-secondary small mb-0">
                            Mettez à jour les informations du service.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Libellé --}}
                        <div class="col-12">
                            <label for="edit_label_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Libellé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tools text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="label"
                                       id="edit_label_{{ $service->id }}"
                                       value="{{ old('label', $service->label) }}"
                                       class="form-control border-start-0"
                                       required>
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_category_id_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Catégorie <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-tags text-secondary"></i>
                                </span>
                                <select name="category_id"
                                        id="edit_category_id_{{ $service->id }}"
                                        class="form-select border-start-0"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                                @selected(old('category_id', $service->category_id) == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Couleur --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_color_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Couleur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-palette text-secondary"></i>
                                </span>
                                <select name="color"
                                        id="edit_color_{{ $service->id }}"
                                        class="form-select border-start-0"
                                        required>
                                    <option value="noir" @selected(old('color', $service->color) === 'noir')>
                                        Noir & blanc
                                    </option>
                                    <option value="couleur" @selected(old('color', $service->color) === 'couleur')>
                                        Couleur
                                    </option>
                                    <option value="non-applicable" @selected(old('color', $service->color) === 'non-applicable')>
                                        Non applicable
                                    </option>
                                </select>
                            </div>
                            <div class="form-text small">
                                Choisir "non applicable" pour les services sans notion de couleur (reliure, saisie...).
                            </div>
                        </div>

                        {{-- Format --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_format_id_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Format <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-aspect-ratio text-secondary"></i>
                                </span>
                                <select name="format_id"
                                        id="edit_format_id_{{ $service->id }}"
                                        class="form-select border-start-0"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($formats as $format)
                                        <option value="{{ $format->id }}"
                                                @selected(old('format_id', $service->format_id) == $format->id)>
                                            {{ $format->name }}@if($format->dimension) ({{ $format->dimension }})@endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Papier (stock) --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_stock_id_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Papier consommé <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-stack text-secondary"></i>
                                </span>
                                <select name="stock_id"
                                        id="edit_stock_id_{{ $service->id }}"
                                        class="form-select border-start-0"
                                        required>
                                    <option value="">— Sélectionner —</option>
                                    @foreach($stocks as $stock)
                                        <option value="{{ $stock->id }}"
                                                @selected(old('stock_id', $service->stock_id) == $stock->id)>
                                            {{ $stock->label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-text small">
                                Le stock qui sera décrémenté à chaque vente de ce service.
                            </div>
                        </div>

                        {{-- Prix --}}
                        <div class="col-12">
                            <label for="edit_price_{{ $service->id }}" class="form-label small fw-semibold text-secondary">
                                Prix <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-cash-coin text-secondary"></i>
                                </span>
                                <input type="number"
                                       name="price"
                                       id="edit_price_{{ $service->id }}"
                                       value="{{ old('price', $service->price) }}"
                                       min="0"
                                       step="0.01"
                                       class="form-control border-start-0"
                                       required>
                                <span class="input-group-text bg-body-tertiary">Ar</span>
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