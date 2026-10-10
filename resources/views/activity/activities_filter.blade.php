{{-- Barre de recherche + filtres --}}
<form action="{{ route('activities.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- Référence --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="ref" class="form-label small fw-semibold text-secondary">
                    Référence
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-hash text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="ref"
                           name="ref"
                           value="{{ request('ref') }}"
                           placeholder="Ex : ACT-2026-0001">
                </div>
            </div>

            {{-- Client --}}
            <div class="col-12 col-md-6 col-lg-3">
                <label for="client_name" class="form-label small fw-semibold text-secondary">
                    Nom du client
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-person text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="client_name"
                           name="client_name"
                           value="{{ request('client_name') }}"
                           placeholder="Ex : Rakoto">
                </div>
            </div>

            {{-- Date de début --}}
            <div class="col-12 col-md-6 col-lg-2">
                <label for="date_from" class="form-label small fw-semibold text-secondary">
                    Du
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-calendar-event text-secondary"></i>
                    </span>
                    <input type="date"
                           class="form-control border-start-0"
                           id="date_from"
                           name="date_from"
                           value="{{ request('date_from') }}">
                </div>
            </div>

            {{-- Date de fin --}}
            <div class="col-12 col-md-6 col-lg-2">
                <label for="date_to" class="form-label small fw-semibold text-secondary">
                    Au
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-calendar-event text-secondary"></i>
                    </span>
                    <input type="date"
                           class="form-control border-start-0"
                           id="date_to"
                           name="date_to"
                           value="{{ request('date_to') }}">
                </div>
            </div>

            {{-- Boutons --}}
            <div class="col-12 col-lg-2 d-flex gap-2 justify-content-lg-end">
                @if(request()->hasAny(['ref', 'client_name', 'date_from', 'date_to']))
                    <a href="{{ route('activities.index') }}"
                       class="btn btn-outline-secondary d-flex align-items-center"
                       title="Réinitialiser">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
                <button type="submit" class="btn btn-primary d-flex align-items-center shadow-sm flex-fill">
                    <i class="bi bi-search me-1"></i>
                    Rechercher
                </button>
            </div>

        </div>
    </div>
</form>