{{-- Modal d'édition du fournisseur #{{ $provider->id }} --}}
<div class="modal fade" id="editProviderModal{{ $provider->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('providers.update', $id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-pencil-square text-primary me-2"></i>
                            Modifier le fournisseur
                        </h5>
                        <p class="text-secondary small mb-0">
                            Mettez à jour les informations du fournisseur.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Nom du fournisseur --}}
                        <div class="col-12">
                            <label for="edit_name_provider_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Nom du fournisseur <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-truck text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name_provider"
                                       id="edit_name_provider_{{ $provider->id }}"
                                       value="{{ old('name_provider', $provider->name_provider) }}"
                                       class="form-control border-start-0"
                                       required>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_mail_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-envelope text-secondary"></i>
                                </span>
                                <input type="email"
                                       name="mail"
                                       id="edit_mail_{{ $provider->id }}"
                                       value="{{ old('mail', $provider->mail) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Téléphone --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_phone_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-telephone text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="phone"
                                       id="edit_phone_{{ $provider->id }}"
                                       value="{{ old('phone', $provider->phone) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_adress_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Adresse
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-house text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="adress"
                                       id="edit_adress_{{ $provider->id }}"
                                       value="{{ old('adress', $provider->adress) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Ville --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_town_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Ville
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-geo-alt text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="town"
                                       id="edit_town_{{ $provider->id }}"
                                       value="{{ old('town', $provider->town) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Pays --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_country_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Pays
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-globe text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="country"
                                       id="edit_country_{{ $provider->id }}"
                                       value="{{ old('country', $provider->country) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Nom du contact --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_name_contact_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Nom du contact
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-person text-secondary"></i>
                                </span>
                                <input type="text"
                                       name="name_contact"
                                       id="edit_name_contact_{{ $provider->id }}"
                                       value="{{ old('name_contact', $provider->name_contact) }}"
                                       class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Note --}}
                        <div class="col-12">
                            <label for="edit_note_{{ $provider->id }}" class="form-label small fw-semibold text-secondary">
                                Note
                            </label>
                            <textarea name="note"
                                      id="edit_note_{{ $provider->id }}"
                                      rows="3"
                                      class="form-control"
                                      placeholder="Informations complémentaires...">{{ old('note', $provider->note) }}</textarea>
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