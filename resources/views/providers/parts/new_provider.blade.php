{{-- Modal de création --}}
<div class="modal fade" id="createProviderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('providers.store') }}" method="POST">
                @csrf

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-truck text-primary me-2"></i>
                            Nouveau fournisseur
                        </h5>
                        <p class="text-secondary small mb-0">
                            Renseignez les informations du nouveau fournisseur.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nom du fournisseur --}}
                        <div class="col-12">
                            <label for="name_provider" class="form-label small fw-semibold text-secondary">
                                Nom du fournisseur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-truck text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name_provider"
                                       id="name_provider"
                                       value="{{ old('name_provider') }}"
                                       class="form-control border-start-0 @error('name_provider') is-invalid @enderror"
                                       placeholder="Ex : Tsena faratazana"
                                       required>
                                @error('name_provider')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-12 col-md-6">
                            <label for="mail" class="form-label small fw-semibold text-secondary">
                                Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-envelope text-secondary"></i>
                                </span>
                                <input type="email"
                                       name="mail"
                                       id="mail"
                                       value="{{ old('mail') }}"
                                       class="form-control border-start-0 @error('mail') is-invalid @enderror"
                                       placeholder="contact@exemple.mg">
                                @error('mail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Téléphone --}}
                        <div class="col-12 col-md-6">
                            <label for="phone" class="form-label small fw-semibold text-secondary">
                                Téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-telephone text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="phone"
                                       id="phone"
                                       value="{{ old('phone') }}"
                                       class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                       placeholder="034 00 000 00">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div class="col-12 col-md-6">
                            <label for="adress" class="form-label small fw-semibold text-secondary">
                                Adresse
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-house text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="adress"
                                       id="adress"
                                       value="{{ old('adress') }}"
                                       class="form-control border-start-0 @error('adress') is-invalid @enderror"
                                       placeholder="Ex : Lot II M 12 Bis">
                                @error('adress')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Ville --}}
                        <div class="col-12 col-md-6">
                            <label for="town" class="form-label small fw-semibold text-secondary">
                                Ville
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-geo-alt text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="town"
                                       id="town"
                                       value="{{ old('town') }}"
                                       class="form-control border-start-0 @error('town') is-invalid @enderror"
                                       placeholder="Ex : Antananarivo">
                                @error('town')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Pays --}}
                        <div class="col-12 col-md-6">
                            <label for="country" class="form-label small fw-semibold text-secondary">
                                Pays
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-globe text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="country"
                                       id="country"
                                       value="{{ old('country') }}"
                                       class="form-control border-start-0 @error('country') is-invalid @enderror"
                                       placeholder="Ex : Madagascar">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Nom du contact --}}
                        <div class="col-12 col-md-6">
                            <label for="name_contact" class="form-label small fw-semibold text-secondary">
                                Nom du contact
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-person text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name_contact"
                                       id="name_contact"
                                       value="{{ old('name_contact') }}"
                                       class="form-control border-start-0 @error('name_contact') is-invalid @enderror"
                                       placeholder="Ex : M. Rajao">
                                @error('name_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-12">
                            <label for="note" class="form-label small fw-semibold text-secondary">
                                Note
                            </label>
                            <textarea name="note"
                                      id="note"
                                      rows="3"
                                      class="form-control @error('note') is-invalid @enderror"
                                      placeholder="Informations complémentaires...">{{ old('note') }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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