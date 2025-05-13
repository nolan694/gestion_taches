@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Header avec animation -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 transition-all duration-300 transform hover:scale-105">
                <span class="bg-gradient-to-r from-blue-500 to-indigo-600 bg-clip-text text-transparent">
                    Liste des Tâches
                </span>
            </h1>
            <a href="{{ route('tasks.create') }}"
               class="flex items-center bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Nouvelle Tâche
            </a>
        </div>

        <!-- Filtres avec animation -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 transition-all duration-300 hover:shadow-lg">
            <form method="GET" action="{{ route('tasks.index') }}" class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Statut -->
                <div class="relative group">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" id="status"
                            class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-400">
                        <option value="">Tous les statuts</option>
                        <option value="en cours" {{ request('status') == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminée" {{ request('status') == 'terminée' ? 'selected' : '' }}>Terminée</option>
                    </select>
                </div>

                <!-- Date d'échéance -->
                <div class="relative group">
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Échéance avant le</label>
                    <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}"
                           class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-400">
                </div>

                <!-- Recherche -->
                <div class="relative group">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Recherche</label>
                    <div class="relative">
                        <input type="text" name="search" id="search" placeholder="Nom ou description..." value="{{ request('search') }}"
                               class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-400">
                        <svg class="absolute left-3 top-3 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Filtre utilisateur (admin) -->
                @if(auth()->user()->role === 'admin')
                    <div class="relative group">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Utilisateur</label>
                        <select name="user_id" id="user_id"
                                class="w-full p-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 group-hover:border-blue-400">
                            <option value="">Tous les utilisateurs</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Bouton Filtrer -->
                <div class="flex items-end">
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-[1.02] shadow-md hover:shadow-lg">
                        <span class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                            </svg>
                            Filtrer
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Liste des tâches -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
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
                            <tr class="transition-all duration-200 hover:bg-gray-50 {{ $task->status == 'terminée' ? 'bg-gray-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900 group">
                                        <a href="{{ route('tasks.show', $task) }}" class="hover:text-blue-600 transition-colors duration-200">
                                            {{ $task->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-gray-600 max-w-xs truncate group">
                                        <a href="{{ route('tasks.show', $task) }}" class="hover:text-blue-600 transition-colors duration-200">
                                            {{ $task->description }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full transition-all duration-200
                                        {{ $task->status == 'terminée' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center group">
                                        @if($task->due_date)
                                            <span class="{{ $task->isLate() ? 'text-red-500 font-semibold' : 'text-gray-600' }} group-hover:text-blue-600 transition-colors duration-200">
                                                {{ $task->due_date->format('d/m/Y') }}
                                                @if($task->isLate() && $task->status != 'terminée')
                                                    <span class="text-xs text-red-500">(en retard)</span>
                                                @endif
                                            </span>
                                        @else
                                            <span class="text-gray-400 group-hover:text-blue-600 transition-colors duration-200">Non définie</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('tasks.edit', $task) }}"
                                           class="text-blue-600 hover:text-blue-800 transition-colors duration-200 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Modifier
                                        </a>
                                        @if ($task->status != 'terminée')
                                            <form action="{{ route('tasks.complete', $task) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                        class="text-green-600 hover:text-green-800 transition-colors duration-200 flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Terminer
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-800 transition-colors duration-200 flex items-center"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche?')">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <p class="text-lg font-medium">Aucune tâche trouvée</p>
                                        <p class="mt-1">Créez votre première tâche pour commencer</p>
                                        <a href="{{ route('tasks.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                            </svg>
                                            Nouvelle Tâche
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tasks->hasPages())
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                    {{ $tasks->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
