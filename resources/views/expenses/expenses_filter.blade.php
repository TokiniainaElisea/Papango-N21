{{-- Filtres --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">

        <form action="{{ route('expenses') }}" method="GET">
            <div class="row g-3 align-items-end">

                {{-- Libellé --}}
                <div class="col-12 col-md-6 col-lg-4">
                    <label for="label" class="form-label small fw-semibold text-secondary">
                        Libellé
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input type="text" name="label" id="label" class="form-control border-start-0"
                            value="{{ request('label') }}" placeholder="Ex : Achat de fournitures">
                    </div>
                </div>

                {{-- Date début --}}
                <div class="col-12 col-md-3 col-lg-3">
                    <label for="begin" class="form-label small fw-semibold text-secondary">
                        Du
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            <i class="bi bi-calendar-event text-secondary"></i>
                        </span>
                        <input type="date" name="begin" id="begin" class="form-control border-start-0"
                            value="{{ request('begin') }}">
                    </div>
                </div>

                {{-- Date fin --}}
                <div class="col-12 col-md-3 col-lg-3">
                    <label for="ending" class="form-label small fw-semibold text-secondary">
                        Au
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0">
                            <i class="bi bi-calendar-check text-secondary"></i>
                        </span>
                        <input type="date" name="ending" id="ending" class="form-control border-start-0"
                            value="{{ request('ending') }}">
                    </div>
                </div>

                {{-- Boutons --}}
                <div class="col-12 col-lg-2 d-flex gap-2 justify-content-lg-end">
                    @if (request()->hasAny(['label', 'type', 'begin', 'ending']))
                        <a href="{{ route('expenses') }}" class="btn btn-outline-secondary d-flex align-items-center"
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
        </form>

    </div>
</div>
