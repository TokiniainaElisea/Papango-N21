<form action="{{ route('services.index') }}" method="GET" class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">

            {{-- Libellé --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="label" class="form-label small fw-semibold text-secondary">
                    Libellé
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-tools text-secondary"></i>
                    </span>
                    <input type="text"
                           class="form-control border-start-0"
                           id="label"
                           name="label"
                           value="{{ request('label') }}"
                           placeholder="Ex : Photocopie A4">
                </div>
            </div>

            {{-- Catégorie --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="category_id" class="form-label small fw-semibold text-secondary">
                    Catégorie
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-tags text-secondary"></i>
                    </span>
                    <select name="category_id"
                            id="category_id"
                            class="form-select border-start-0">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                    @selected(request('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Papier --}}
            <div class="col-12 col-md-6 col-lg-4">
                <label for="stock_id" class="form-label small fw-semibold text-secondary">
                    Papier
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-body-tertiary border-end-0">
                        <i class="bi bi-stack text-secondary"></i>
                    </span>
                    <select name="stock_id"
                            id="stock_id"
                            class="form-select border-start-0">
                        <option value="">Tous les papiers</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}"
                                    @selected(request('stock_id') == $stock->id)>
                                {{ $stock->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Boutons --}}
            <div class="col-12 d-flex gap-2 justify-content-end">
                @if(request()->hasAny(['label', 'category_id', 'stock_id']))
                    <a href="{{ route('services.index') }}"
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