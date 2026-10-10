<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — Papango N21</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Seul style custom : le fond dégradé de l'app */
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #00050d 0%, #1a2332 40%, #03337a 130%);
            background-size: 200% 200%;
            animation: gradientShift 12s ease infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
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
                                style="width: 85px; height: 85px;">
                                <img src="icon.png" alt="logo Papango N21" style="height: 70px; width: auto;">
                            </div>
                            <h1 class="h4 fw-bold mb-1">Papango N21</h1>
                            <p class="text-secondary small mb-0">
                                Gestion multiservices
                            </p>
                        </div>

                        {{-- Erreur d'authentification --}}
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-start" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                                <div class="small">
                                    @foreach ($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Formulaire --}}
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            {{-- Email --}}
                            <div class="mb-3">
                                <label for="email" class="form-label small fw-semibold text-secondary">
                                    Adresse email
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-body-tertiary border-end-0">
                                        <i class="bi bi-envelope text-secondary"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                        class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" placeholder="exemple@papango.local" required
                                        autofocus>
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
                                    <input type="password" name="password" id="password"
                                        class="form-control border-start-0 @error('password') is-invalid @enderror"
                                        placeholder="••••••••" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Remember --}}
                            <div class="form-check mb-4">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember" class="form-check-label small">
                                    Se souvenir de moi
                                </label>
                            </div>

                            {{-- Bouton --}}
                            <button type="submit"
                                class="btn btn-primary w-100 d-flex align-items-center justify-content-center shadow-sm"
                                id="submitBtn">
                                <i class="bi bi-box-arrow-in-right me-1"></i>
                                Se connecter
                            </button>

                        </form>

                    </div>

                    {{-- Pied de carte --}}
                    <div class="card-footer bg-body-tertiary border-0 text-center py-3">
                        <small class="text-secondary d-block">
                            <i class="bi bi-shield-lock me-1"></i>
                            Accès réservé — v1.0.0
                        </small>

                        {{-- Lien "Créer un compte" (visible seulement si aucun utilisateur n'existe) --}}
                        @if (!\App\Models\User::exists())
                            <div class="mt-2 pt-2 border-top border-secondary-subtle">
                                <small class="text-secondary">
                                    Aucun compte n'existe encore ?
                                </small>
                                <a href="{{ route('register') }}"
                                    class="btn btn-sm btn-outline-primary d-inline-flex align-items-center ms-2">
                                    <i class="bi bi-person-plus me-1"></i>
                                    Créer un compte
                                </a>
                            </div>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script>
        // Feedback visuel au moment de la soumission
        document.querySelector('form').addEventListener('submit', () => {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = `
                <span class="spinner-border spinner-border-sm me-2"></span>
                Connexion...
            `;
        });
    </script>

</body>

</html>
