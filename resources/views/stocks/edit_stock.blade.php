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
                    <li class="breadcrumb-item">
                        <a href="{{ route('stocks.show', $stock) }}" class="text-decoration-none">
                            {{ $stock->label }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Modifier</li>
                </ol>
            </nav>
            <h1 class="h3 fw-semibold mb-0 d-flex align-items-center">
                <i class="bi bi-pencil-square text-primary me-2"></i>
                Modifier le papier
            </h1>
            <p class="text-secondary mb-0 small">
                Mettez à jour les informations de <strong>{{ $stock->label }}</strong>.
            </p>
        </div>

        <a href="{{ route('stocks.show', $stock) }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour à la fiche
        </a>
    </div>

    <form action="{{ route('stocks.update', $stock) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- Colonne principale : informations du papier --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-3"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            Informations du papier
                        </h2>

                        <div class="row g-3">

                            {{-- Label --}}
                            <div class="col-12">
                                <label for="label" class="form-label small fw-semibold text-secondary">
                                    Nom du papier <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-stack text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="label"
                                           id="label"
                                           value="{{ old('label', $stock->label) }}"
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
                                    <select name="paper_type_id"
                                            id="paper_type_id"
                                            class="form-select border-start-0 @error('paper_type_id') is-invalid @enderror"
                                            required>
                                        <option value="">— Sélectionner —</option>
                                        @foreach($paperTypes as $type)
                                            <option value="{{ $type->id }}"
                                                    @selected(old('type_id', $stock->type_id) == $type->id)>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('paper_type_id')
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
                                            <option value="{{ $format->id }}"
                                                    @selected(old('format_id', $stock->format_id) == $format->id)>
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
                                            <option value="{{ $provider->id }}"
                                                    @selected(old('provider_id', $stock->provider_id) == $provider->id)>
                                                {{ $provider->name_provider }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('provider_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Encart : gestion des mouvements --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm bg-body-tertiary">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">

                            <div class="d-flex align-items-start">
                                <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                     style="width: 48px; height: 48px;">
                                    <i class="bi bi-sliders fs-5"></i>
                                </div>
                                <div>
                                    <h3 class="h6 fw-semibold mb-1">
                                        Gestion des mouvements de stock
                                    </h3>
                                    <p class="text-secondary small mb-0" style="max-width: 600px;">
                                        Le stock n'est pas modifiable directement ici. Les quantités
                                        évoluent uniquement via des <strong>mouvements</strong>
                                        (entrées et sorties). Pour ajuster le stock, enregistrez un
                                        nouveau mouvement depuis la page dédiée.
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('stocks-movement.index', $stock) }}"
                               class="btn btn-outline-primary d-flex align-items-center flex-shrink-0">
                                <i class="bi bi-sliders me-1"></i>
                                Gérer les mouvements
                            </a>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('stocks.show', $stock) }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-lg me-1"></i>
                        Mettre à jour
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection