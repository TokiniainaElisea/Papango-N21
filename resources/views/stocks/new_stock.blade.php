@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item">
                        <a href="{{ route('stocks.index') }}" class="text-decoration-none">Stock</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Nouveau stock</li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-plus-square text-primary me-2"></i>
                Nouveau 
            </h1>
        </div>

        <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>
    </div>

    <form action="{{ route('stocks.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            {{-- Colonne principale : informations du papier --}}
            <div class="col-12 col-lg-7">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            Informations du papier
                        </h2>

                        <div class="row g-3">

                            {{-- Label --}}
                            <div class="col-12">
                                <label for="label" class="form-label small fw-semibold text-secondary">
                                    Nom <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-stack text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="label"
                                           id="label"
                                           value="{{ old('label') }}"
                                           class="form-control border-start-0 @error('label') is-invalid @enderror"
                                           placeholder="Ex : Papier A4 80g blanc"
                                           required>
                                    @error('label')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Type de papier --}}
                            <div class="col-12 col-md-6">
                                <label for="paper_type_id" class="form-label small fw-semibold text-secondary">
                                    Type de papier <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-tags text-secondary"></i>
                                    </span>
                                    <select name="type_id"
                                            id="type_id"
                                            class="form-select border-start-0 @error('type_id') is-invalid @enderror"
                                            required>
                                        <option value="">— Sélectionner —</option>
                                        @foreach($paperTypes as $type)
                                            <option value="{{ $type->id }}" @selected(old('type_id') == $type->id)>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Format --}}
                            <div class="col-12 col-md-6">
                                <label for="format_id" class="form-label small fw-semibold text-secondary">
                                    Format <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-aspect-ratio text-secondary"></i>
                                    </span>
                                    <select name="format_id"
                                            id="format_id"
                                            class="form-select border-start-0 @error('format_id') is-invalid @enderror"
                                            required>
                                        <option value="">— Sélectionner —</option>
                                        @foreach($formats as $format)
                                            <option value="{{ $format->id }}" @selected(old('format_id') == $format->id)>
                                                {{ $format->name }}@if($format->dimension) ({{ $format->dimension }})@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('format_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Fournisseur --}}
                            <div class="col-12">
                                <label for="provider_id" class="form-label small fw-semibold text-secondary">
                                    Fournisseur <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-truck text-secondary"></i>
                                    </span>
                                    <select name="provider_id"
                                            id="provider_id"
                                            class="form-select border-start-0 @error('provider_id') is-invalid @enderror"
                                            required>
                                        <option value="">— Sélectionner —</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}" @selected(old('provider_id') == $provider->id)>
                                                {{ $provider->name_provider }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provider_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text small">
                                    Le fournisseur principal.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Colonne secondaire : premier mouvement --}}
            <div class="col-12 col-lg-5">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            Premier mouvement en stock
                        </h2>

                        <p class="text-secondary small mb-3">
                            À la création, on enregistre automatiquement une
                            <strong>entrée en stock</strong>. Les sorties et mouvements
                            ultérieurs se géreront depuis la fiche.
                        </p>

                        {{-- Movement type (forcé) --}}
                        <input type="hidden" name="movement_type" value="entry">

                        <div class="row g-3">

                            {{-- Stock initial --}}
                            <div class="col-12">
                                <label for="initial_stock" class="form-label small fw-semibold text-secondary">
                                    Stock initial <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-box-seam text-secondary"></i>
                                    </span>
                                    <input type="number"
                                           name="initial_stock"
                                           id="initial_stock"
                                           value="{{ old('initial_stock', 0) }}"
                                           min="0"
                                           class="form-control border-start-0 @error('initial_stock') is-invalid @enderror"
                                           placeholder="Ex : 500"
                                           required>
                                    @error('initial_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text small">
                                    Quantité de stock lors de l'entrée initiale.
                                </div>
                            </div>

                            {{-- Prix fournisseur --}}
                            <div class="col-12">
                                <label for="provider_price" class="form-label small fw-semibold text-secondary">
                                    Prix fournisseur <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-cash-coin text-secondary"></i>
                                    </span>
                                    <input type="number"
                                           name="provider_price"
                                           id="provider_price"
                                           value="{{ old('provider_price') }}"
                                           min="0"
                                           step="0.01"
                                           class="form-control border-start-0 @error('provider_price') is-invalid @enderror"
                                           placeholder="Ex : 15000"
                                           required>
                                    <span class="input-group-text bg-body-tertiary">Ar</span>
                                    @error('provider_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Date d'entrée --}}
                            <div class="col-12">
                                <label for="entry_stock" class="form-label small fw-semibold text-secondary">
                                    Date d'entrée <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-calendar-event text-secondary"></i>
                                    </span>
                                    <input type="date"
                                           name="entry_stock"
                                           id="entry_stock"
                                           value="{{ old('entry_stock', now()->format('Y-m-d')) }}"
                                           class="form-control border-start-0 @error('entry_stock') is-invalid @enderror"
                                           required>
                                    @error('entry_stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('stocks.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-lg me-1"></i>
                        Créer le papier
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection