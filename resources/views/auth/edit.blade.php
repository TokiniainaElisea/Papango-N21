@extends('layout')

@section('content')
<div class="container p-1">

    {{-- En-tête --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-semibold mb-1 d-flex align-items-center">
                <i class="bi bi-person-gear text-primary me-2"></i>
                Mon profil
            </h1>
            <p class="text-secondary mb-0 small">
                Gérez les informations de votre entreprise et vos identifiants de connexion.
            </p>
        </div>

        <a href="{{ route('home.index') }}" class="btn btn-outline-secondary d-flex align-items-center">
            <i class="bi bi-arrow-left me-1"></i>
            Retour
        </a>
    </div>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">

            {{-- COLONNE PRINCIPALE : INFOS ENTREPRISE --}}
            <div class="col-12 col-lg-8">

                {{-- Carte : Informations de l'entreprise --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-4 pb-2 border-bottom"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-building me-1"></i>
                            Informations de l'entreprise
                        </h2>

                        <div class="row g-3">

                            {{-- Nom de la société --}}
                            <div class="col-12">
                                <label for="name" class="form-label small fw-semibold text-secondary">
                                    Nom de la société <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-building text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           value="{{ old('name', $user->name) }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nom du gérant --}}
                            <div class="col-12 col-md-6">
                                <label for="manager" class="form-label small fw-semibold text-secondary">
                                    Nom du gérant <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-person text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="manager"
                                           id="manager"
                                           class="form-control border-start-0 @error('manager') is-invalid @enderror"
                                           value="{{ old('manager', $user->manager) }}"
                                           required>
                                    @error('manager')
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
                                        <i class="bi bi-geo-alt text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="adress"
                                           id="adress"
                                           class="form-control border-start-0 @error('adress') is-invalid @enderror"
                                           value="{{ old('adress', $user->adress) }}"
                                           placeholder="Ex : Lot II M 12 Bis, Antananarivo">
                                    @error('adress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- NIF --}}
                            <div class="col-12 col-md-4">
                                <label for="nif" class="form-label small fw-semibold text-secondary">
                                    NIF
                                </label>
                                <input type="text"
                                       name="nif"
                                       id="nif"
                                       class="form-control @error('nif') is-invalid @enderror"
                                       value="{{ old('nif', $user->nif) }}"
                                       placeholder="N° fiscal">
                                @error('nif')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- STAT --}}
                            <div class="col-12 col-md-4">
                                <label for="stat" class="form-label small fw-semibold text-secondary">
                                    STAT
                                </label>
                                <input type="text"
                                       name="stat"
                                       id="stat"
                                       class="form-control @error('stat') is-invalid @enderror"
                                       value="{{ old('stat', $user->stat) }}"
                                       placeholder="N° statistique">
                                @error('stat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- RCS --}}
                            <div class="col-12 col-md-4">
                                <label for="rcs" class="form-label small fw-semibold text-secondary">
                                    RCS
                                </label>
                                <input type="text"
                                       name="rcs"
                                       id="rcs"
                                       class="form-control @error('rcs') is-invalid @enderror"
                                       value="{{ old('rcs', $user->rcs) }}"
                                       placeholder="N° registre">
                                @error('rcs')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Carte : Identifiants --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-4 pb-2 border-bottom"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-shield-lock me-1"></i>
                            Identifiants de connexion
                        </h2>

                        <div class="row g-3">

                            {{-- Email --}}
                            <div class="col-12">
                                <label for="email" class="form-label small fw-semibold text-secondary">
                                    Adresse email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->email) }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- COLONNE LATÉRALE : MOT DE PASSE --}}
            <div class="col-12 col-lg-4">

                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">

                        <h2 class="h6 text-uppercase text-secondary fw-bold mb-4 pb-2 border-bottom"
                            style="font-size: .7rem; letter-spacing: .5px;">
                            <i class="bi bi-key me-1"></i>
                            Mot de passe
                        </h2>

                        <div class="alert alert-info d-flex align-items-start mb-4" role="alert">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div class="small">
                                Laissez vide si vous ne souhaitez pas changer votre mot de passe.
                            </div>
                        </div>

                        <div class="row g-3">

                            {{-- Nouveau mot de passe --}}
                            <div class="col-12">
                                <label for="password" class="form-label small fw-semibold text-secondary">
                                    Nouveau mot de passe
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-lock text-secondary"></i>
                                    </span>
                                    <input type="password"
                                           name="password"
                                           id="password"
                                           class="form-control border-start-0 @error('password') is-invalid @enderror"
                                           placeholder="Au moins 6 caractères"
                                           autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Confirmation --}}
                            <div class="col-12">
                                <label for="password_confirmation" class="form-label small fw-semibold text-secondary">
                                    Confirmer le mot de passe
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-lock-fill text-secondary"></i>
                                    </span>
                                    <input type="password"
                                           name="password_confirmation"
                                           id="password_confirmation"
                                           class="form-control border-start-0"
                                           placeholder="••••••••"
                                           autocomplete="new-password">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

            {{-- ACTIONS --}}
            <div class="col-12">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('home.index') }}" class="btn btn-outline-secondary">
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-check-lg me-1"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection