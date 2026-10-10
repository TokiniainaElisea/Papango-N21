<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Traite la tentative de connexion.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('home.index'));
        }

        return back()
            ->withErrors([
                'email' => 'Ces identifiants ne correspondent à aucun compte.',
            ])
            ->onlyInput('email');
    }

    /**
     * Affiche le formulaire d'inscription.
     * Accessible seulement si aucun utilisateur n'existe encore.
     */
    public function showRegister()
    {
        // S'il y a déjà au moins un utilisateur, on bloque l'inscription
        if (User::exists()) {
            return redirect()->route('login');
        }

        return view('auth.register');
    }

    /**
     * Traite la création du compte.
     */
    public function register(Request $request)
    {
        // Sécurité : blocage si un utilisateur existe déjà
        if (User::exists()) {
            return redirect()->route('login');
        }

        // Validation
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Le nom est obligatoire.',
            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'L\'adresse email est invalide.',
            'email.unique'       => 'Cette adresse email est déjà utilisée.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        // Création de l'utilisateur
        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // hashé automatiquement grâce au cast 'hashed'
        ]);

        // Connexion automatique
        Auth::login($user);

        return redirect()
            ->route('home.index')
            ->with('success', 'Votre compte a été créé avec succès.');
    }

    /**
     * Déconnexion.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}