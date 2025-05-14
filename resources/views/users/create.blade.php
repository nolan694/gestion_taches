@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Créer un nouvel utilisateur</h2>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
            <div class="mb-4">
                <ul class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded-lg">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <!-- Mot de passe -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <!-- Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            <!-- Rôle -->
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select name="role" id="role"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                    <option value="">-- Sélectionner un rôle --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="utilisateur" {{ old('role') === 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>
                </select>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('users.index') }}"
                   class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    Annuler
                </a>
                <button type="submit"
                        class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 transition">
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
