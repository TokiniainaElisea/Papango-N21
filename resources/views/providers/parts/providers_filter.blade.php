{{-- Barre de recherche + filtres --}}
<form action="{{ route('providers.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- Nom du fournisseur --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="name_provider" class="form-label small fw-semibold text-secondary">
                    Nom du fournisseur
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-truck text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="name_provider"
                           name="name_provider"
                           value="{{ request('name_provider') }}"
                           placeholder="Ex : Tsena faratazana">
                </div>
            </div>

            {{-- Email --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="mail" class="form-label small fw-semibold text-secondary">
                    Email
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-envelope text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="mail"
                           name="mail"
                           value="{{ request('mail') }}"
                           placeholder="contact@exemple.mg">
                </div>
            </div>

            {{-- Téléphone --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="phone" class="form-label small fw-semibold text-secondary">
                    Téléphone
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-telephone text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="phone"
                           name="phone"
                           value="{{ request('phone') }}"
                           placeholder="034 00 000 00">
                </div>
            </div>

            {{-- Ville --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="town" class="form-label small fw-semibold text-secondary">
                    Ville
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-geo-alt text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="town"
                           name="town"
                           value="{{ request('town') }}"
                           placeholder="Ex : Antananarivo">
                </div>
            </div>

            {{-- Boutons --}}
            <div class="col-12 d-flex gap-2 justify-content-end">
                @if(request()->hasAny(['name_provider', 'mail', 'phone', 'town']))
                    <a href="{{ route('providers.index') }}"
                       class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i>
                        Réinitialiser
                    </a>
                @endif
                <button type="submit" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="bi bi-search me-1"></i>
                    Rechercher
                </button>
            </div>

        </div>
    </div>
</form>