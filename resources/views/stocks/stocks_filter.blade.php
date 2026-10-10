{{-- Barre de recherche + filtres --}}
<form action="{{ route('stocks.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- Nom du papier --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="label" class="form-label small fw-semibold text-secondary">
                    Nom du papier
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-stack text-secondary"></i>
                    </span>
                    <input type="text" class="form-control border-start-0" id="label" name="label"
                        value="{{ request('label') }}" placeholder="Ex : Papier A4 80g">
                </div>
            </div>

            {{-- Fournisseur --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="provider_id" class="form-label small fw-semibold text-secondary">
                    Fournisseur
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-truck text-secondary"></i>
                    </span>
                    <select name="provider_id" id="provider_id" class="form-select border-start-0">
                        <option value="">Tous les fournisseurs</option>
                        @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}" @selected(request('provider_id') == $provider->id)>
                                {{ $provider->name_provider }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="col-12 col-lg-4 d-flex gap-2 justify-content-lg-start">
                <button type="submit" class="btn btn-primary d-flex align-items-center shadow-sm">
                    <i class="bi bi-search me-1"></i>
                    Rechercher
                </button>
                 @if (request()->hasAny(['label', 'provider_id']))
                    <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-x-lg me-1"></i>
                        Réinitialiser
                    </a>
                @endif
            </div>

        </div>
    </div>
</form>
