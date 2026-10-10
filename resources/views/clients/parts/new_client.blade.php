{{-- Modal de création --}}
<div class="modal fade" id="createClientModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                {{-- En-tête --}}
                <div class="modal-header border-0 pb-0">
                    <div>
                        <h5 class="modal-title d-flex align-items-center">
                            <i class="bi bi-person-plus-fill text-primary me-2"></i>
                            Nouveau client
                        </h5>
                        <p class="text-secondary small mb-0">
                            Renseignez les informations du nouveau client.
                        </p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                {{-- Corps --}}
                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Titre --}}
                        <div class="col-12 col-md-3">
                            <label for="title" class="form-label small fw-semibold text-secondary">
                                Titre
                            </label>
                            <select name="title" id="title"
                                class="form-select @error('title') is-invalid @enderror">
                                <option value="">—</option>
                                @foreach (['M.', 'Mme', 'Mlle'] as $title)
                                    <option value="{{ $title }}" @selected(old('title') === $title)>
                                        {{ $title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nom --}}
                        <div class="col-12 col-md-4">
                            <label for="name" class="form-label small fw-semibold text-secondary">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="Ex : Rakoto" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Prénom --}}
                        <div class="col-12 col-md-5">
                            <label for="firstname" class="form-label small fw-semibold text-secondary">
                                Prénom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}"
                                class="form-control @error('firstname') is-invalid @enderror" placeholder="Ex : Jean">
                            @error('firstname')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Téléphone --}}
                        <div class="col-12 col-md-6">
                            <label for="phone" class="form-label small fw-semibold text-secondary">
                                Téléphone <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-body-tertiary border-end-0">
                                    <i class="bi bi-telephone text-secondary"></i>
                                </span>
                                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control border-start-0 @error('phone') is-invalid @enderror"
                                    placeholder="034 00 000 00">
                                @error('phone')
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
                                <input type="text" name="town" id="town" value="{{ old('town') }}"
                                    class="form-control border-start-0 @error('town') is-invalid @enderror"
                                    placeholder="Ex : Antananarivo">
                                @error('town')
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
                                <input type="text" name="adress" id="adress" value="{{ old('adress') }}"
                                    class="form-control border-start-0 @error('adress') is-invalid @enderror"
                                    placeholder="Ex : Lot II M 12 Bis">
                                @error('adress')
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
