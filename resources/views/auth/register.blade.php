<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte — Papango N21</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0d1117 0%, #1a2332 40%, #0d6efd 130%);
            background-size: 200% 200%;
            animation: gradientShift 12s ease infinite;
        }

        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-6">

                <div class="card border-0 shadow-lg">

                    <div class="card-body p-4 p-md-5">

                        {{-- Logo + titre --}}
                        <div class="text-center mb-4">
                            <div class="rounded-4 bg-primary-subtle text-primary d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 72px; height: 72px;">
                                <i class="bi bi-person-plus-fill" style="font-size: 2rem;"></i>
                            </div>
                            <h1 class="h4 fw-bold mb-1">Créer un compte</h1>
                            <p class="text-secondary small mb-0">
                                Première configuration de Papango N21
                            </p>
                        </div>

                        {{-- Info : première fois --}}
                        <div class="alert alert-info d-flex align-items-start" role="alert">
                            <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                            <div class="small">
                                Ce formulaire n'est accessible que lors de la première
                                configuration. Une fois votre compte créé, l'inscription
                                sera définitivement bloquée.
                            </div>
                        </div>

                        {{-- Erreurs --}}
                        @if($errors->any())
                            <div class="alert alert-danger d-flex align-items-start" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <div class="small">
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Formulaire --}}
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            {{-- Nom --}}
                            <div class="mb-3">
                                <label for="name" class="form-label small fw-semibold text-secondary">
                                    Nom complet
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-person text-secondary"></i>
                                    </span>
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control border-start-0 @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           placeholder="Ex : Naruto Uzumaki"
                                           required
                                           autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold text-secondary">
                                    Adresse email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control border-start-0 @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           placeholder="exemple@papango.local"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Mot de passe --}}
                            <div class="mb-3">
                                <label for="password" class="form-label small fw-semibold text-secondary">
                                    Mot de passe
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
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text small">
                                    Minimum 6 caractères.
                                </div>
                            </div>

                            {{-- Confirmation --}}
                            <div class="mb-4">
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
                                           required>
                                </div>
                            </div>

                            {{-- Bouton --}}
                            <button type="submit"
                                    class="btn btn-primary w-100 d-flex align-items-center justify-content-center shadow-sm"
                                    id="submitBtn">
                                <i class="bi bi-check-lg me-1"></i>
                                Créer mon compte
                            </button>

                        </form>

                    </div>

                    {{-- Pied de carte --}}
                    <div class="card-footer bg-body-tertiary border-0 text-center py-3">
                        <small class="text-secondary">
                            <i class="bi bi-shield-lock me-1"></i>
                            Configuration initiale — v1.0.0
                        </small>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', () => {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Création...
            `;
        });
    </script>

</body>
</html>