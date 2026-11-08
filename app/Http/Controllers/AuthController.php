<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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
        if (User::exists()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            // Entreprise
            'name'     => ['required', 'string', 'max:255'],
            'manager'  => ['required', 'string', 'max:255'],
            'adress'   => ['nullable', 'string', 'max:255'],
            'nif'      => ['nullable', 'string', 'max:50'],
            'stat'     => ['nullable', 'string', 'max:50'],
            'rcs'      => ['nullable', 'string', 'max:50'],

            // Compte
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Le nom de la société est obligatoire.',
            'manager.required'   => 'Le nom du gérant est obligatoire.',
            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'L\'adresse email est invalide.',
            'email.unique'       => 'Cette adresse email est déjà utilisée.',
            'password.required'  => 'Le mot de passe est obligatoire.',
            'password.min'       => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'manager'  => $validated['manager'],
            'adress'   => $validated['adress'] ?? null,
            'nif'      => $validated['nif'] ?? null,
            'stat'     => $validated['stat'] ?? null,
            'rcs'      => $validated['rcs'] ?? null,
            'email'    => $validated['email'],
            'password' => $validated['password'],
        ]);

        Auth::login($user);

        return redirect()
            ->route('home.index')
            ->with('success', 'Votre compte a été créé avec succès.');
    }

    //update user info
    public function edit()
    {
        return view('auth.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            // Entreprise
            'name'     => ['required', 'string', 'max:255'],
            'manager'  => ['required', 'string', 'max:255'],
            'adress'   => ['nullable', 'string', 'max:255'],
            'nif'      => ['nullable', 'string', 'max:50'],
            'stat'     => ['nullable', 'string', 'max:50'],
            'rcs'      => ['nullable', 'string', 'max:50'],

            // Compte
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required'      => 'Le nom de la société est obligatoire.',
            'manager.required'   => 'Le nom du gérant est obligatoire.',
            'email.required'     => 'L\'adresse email est obligatoire.',
            'email.email'        => 'L\'adresse email est invalide.',
            'email.unique'       => 'Cette adresse email est déjà utilisée par un autre compte.',
            'password.min'       => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
        ]);

        // Mise à jour des infos de base
        $user->name    = $validated['name'];
        $user->manager = $validated['manager'];
        $user->adress  = $validated['adress'] ?? null;
        $user->nif     = $validated['nif'] ?? null;
        $user->stat    = $validated['stat'] ?? null;
        $user->rcs     = $validated['rcs'] ?? null;
        $user->email   = $validated['email'];

        // Mot de passe : seulement si rempli
        if (! empty($validated['password'])) {
            $user->password = $validated['password']; // hashé par le cast
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Vos informations ont été mises à jour avec succès.');
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
