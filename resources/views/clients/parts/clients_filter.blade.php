{{-- Barre de recherche + filtres --}}
<form action="{{ route('clients.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- Nom --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="name" class="form-label small fw-semibold text-secondary">
                    Nom
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-person text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="name" name="name"
                        value="{{ request('name') }}" placeholder="Ex : Rakoto">
                </div>
            </div>

            {{-- Prénom --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="firstname" class="form-label small fw-semibold text-secondary">
                    Prénom
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-person text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="firstname" name="firstname"
                        value="{{ request('firstname') }}" placeholder="Ex : Jean">
                </div>
            </div>

            {{-- Numéro client --}}
            <div class="col-12 col-md-6 col-lg-2">
                <label for="client_number" class="form-label small fw-semibold text-secondary">
                    N° client
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-hash text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="client_number" name="client_number"
                        value="{{ request('client_number') }}" placeholder="CLI-001">
                </div>
            </div>

            {{-- Téléphone --}}
            <div class="col-12 col-md-6 col-lg-2">
                <label for="phone" class="form-label small fw-semibold text-secondary">
                    Téléphone
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-telephone text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="phone" name="phone"
                        value="{{ request('phone') }}" placeholder="034 00 000 00">
                </div>
            </div>

            {{-- Boutons --}}
            <div class="col-12 col-lg-2 d-flex gap-2">
                <button type="submit"
                    class="btn btn-primary flex-fill d-flex align-items-center justify-content-center">
                    <i class="bi bi-search me-1"></i>
                    Rechercher
                </button>
                @if (request()->hasAny(['name', 'firstname', 'client_number', 'phone']))
                    <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary d-flex align-items-center"
                        title="Réinitialiser">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>

        </div>
    </div>
</form>
