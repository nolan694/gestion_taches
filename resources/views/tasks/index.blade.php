@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Liste des Tâches</h1>
            <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                + Nouvelle Tâche
            </a>
        </div>

        <!-- Filtrage et recherche -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form method="GET" action="{{ route('tasks.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Tous les statuts</option>
                        <option value="en cours" {{ request('status') == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminée" {{ request('status') == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Échéance avant le</label>
                    <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}"
                           class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <input type="text" name="search" id="search" placeholder="Nom ou description..." value="{{ request('search') }}"
                           class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Filtre par utilisateur, uniquement pour l'admin -->
                @if(auth()->user()->role === 'admin')
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                        <select name="user_id" id="user_id" class="w-full p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Tous les utilisateurs</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md transition duration-200 w-full">
                        Filtrer
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des tâches -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Échéance</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($tasks as $task)
                            <tr class="{{ $task->status == 'terminée' ? 'bg-gray-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $task->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-600 max-w-xs truncate">{{ $task->description }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                        {{ $task->status == 'terminée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-gray-600 {{ $task->isLate() ? 'text-red-500 font-semibold' : '' }}">
                                        @if($task->due_date)
                                            {{ $task->due_date->format('d/m/Y') }}
                                            @if($task->isLate() && $task->status != 'terminée')
                                                <span class="text-xs text-red-500">(en retard)</span>
                                            @endif
                                        @else
                                            Non définie
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-600 hover:text-blue-900 mr-2">Modifier</a>
                                        @if ($task->status != 'terminée')
                                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Terminer</button>
                                            </form>
                                        @endif
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche?')">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Aucune tâche trouvée. Créez votre première tâche!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tasks->hasPages())
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
