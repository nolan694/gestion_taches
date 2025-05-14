<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Afficher la liste des utilisateurs (accessible seulement aux admins)
    public function index()
    {
        // Vérifie si l'utilisateur est un admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé, vous n\'êtes pas administrateur.');
        }

        // Récupère tous les utilisateurs
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6',
        'role' => 'required|in:admin,utilisateur',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
}

    // Afficher le formulaire d'édition d'un utilisateur
    public function edit(User $user)
    {
        // Vérifie si l'utilisateur est un admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé, vous n\'êtes pas administrateur.');
        }

        return view('users.edit', compact('user'));
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, User $user)
    {
        // Vérifie si l'utilisateur est un admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé, vous n\'êtes pas administrateur.');
        }

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:utilisateur,admin', // Assure que le rôle soit valide
        ]);

        // Met à jour les informations de l'utilisateur
        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('users.index')->with('success', 'Utilisateur mis à jour avec succès');
    }

    // Supprimer un utilisateur
    public function destroy(User $user)
    {
        // Vérifie si l'utilisateur est un admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé, vous n\'êtes pas administrateur.');
        }

        // Supprime l'utilisateur
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès');
    }
}
