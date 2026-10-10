@php
    $id;
    $client;
@endphp

{{-- Modal d'édition --}}
<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable text-start">
        <div class="modal-content border-0 shadow">

            <form method="POST" action="{{ route('clients.update', $client->id) }}">
                @csrf
                @method('PUT')

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-pencil-square text-primary me-2"></i>
                            Modifier le client
                        </h5>
                        <p class="text-secondary small mb-0">
                            Mettez à jour les informations du client.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Titre --}}
                        <div class="col-12 col-md-2">
                            <label for="edit_title" class="form-label small fw-semibold text-secondary">
                                Titre
                            </label>
                            <select name="title" class="form-select">
                                <option value="{{ $client->title }}">{{ $client->title }}</option>
                                @foreach (['M.', 'Mme', 'Mlle'] as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nom --}}
                        <div class="col-12 col-md-4">
                            <label for="edit_name" class="form-label small fw-semibold text-secondary">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" value="{{ $client->name }}" class="form-control" required>
                        </div>

                        {{-- Prénom --}}
                        <div class="col-12 col-md-5">
                            <label for="edit_firstname" class="form-label small fw-semibold text-secondary">
                                Prénom
                            </label>
                            <input type="text" name="firstname" value="{{ $client->firstname }}"
                                class="form-control">
                        </div>
                        {{-- Téléphone --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_phone" class="form-label small fw-semibold text-secondary">
                                Téléphone
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-telephone text-secondary"></i>
                                </span>
                                <input type="text" name="phone" value="{{ $client->phone }}"
                                    class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Ville --}}
                        <div class="col-12 col-md-6">
                            <label for="edit_town" class="form-label small fw-semibold text-secondary">
                                Ville
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-geo-alt text-secondary"></i>
                                </span>
                                <input type="text" name="town" value="{{ $client->town }}"
                                    class="form-control border-start-0">
                            </div>
                        </div>

                        {{-- Adresse --}}
                        <div class="col-12">
                            <label for="edit_adress" class="form-label small fw-semibold text-secondary">
                                Adresse
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-house text-secondary"></i>
                                </span>
                                <input type="text" name="adress" value="{{ $client->adress }}"
                                    class="form-control border-start-0">
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
