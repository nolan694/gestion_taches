@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header avec animation -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 transition-all duration-300 transform hover:scale-[1.01]">
            <span class="bg-gradient-to-r from-blue-500 to-indigo-600 bg-clip-text text-transparent">
                Tableau de bord - {{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
            </span>
        </h1>
    </div>

    <!-- Statistiques principales avec animations -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Carte Total Tâches -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">
                            {{ $user->role === 'admin' ? 'Total des tâches' : 'Mes tâches totales' }}
                        </h2>
                        <p class="mt-1 text-3xl font-bold text-gray-800">{{ $totalTasks }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Tâches Terminées -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Terminées</h2>
                        <p class="mt-1 text-3xl font-bold text-green-600">{{ $tasksCompleted }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $totalTasks > 0 ? round(($tasksCompleted/$totalTasks)*100) : 0 }}% du total</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Tâches En Cours -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 mr-4">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">En cours</h2>
                        <p class="mt-1 text-3xl font-bold text-yellow-600">{{ $tasksInProgress }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Autres statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Carte Tâches Aujourd'hui -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-indigo-100 mr-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">Aujourd'hui</h2>
                        <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $todaysTasks }}</p>
                        <p class="text-xs text-gray-500 mt-1">Tâches à faire</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Carte Tâches En Retard -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 mr-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-medium text-gray-500">En retard</h2>
                        <p class="mt-1 text-2xl font-bold text-red-600">{{ $tasksOverdue }}</p>
                        <p class="text-xs text-gray-500 mt-1">À traiter rapidement</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tâches récentes -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-lg">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Tâches récentes</h2>
                <a href="{{ route('tasks.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center transition-colors duration-200">
                    Voir toutes
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            @if($recentTasks->isEmpty())
                <div class="text-center py-8">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-gray-500">Aucune tâche récente</p>
                </div>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($recentTasks as $task)
                        <li class="py-4 flex items-center justify-between transition-colors duration-200 hover:bg-gray-50 px-2 -mx-2 rounded-lg">
                            <div class="flex items-center min-w-0">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-medium mr-4">
                                    {{ strtoupper(substr($task->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-lg font-medium text-gray-900 truncate">{{ $task->name }}</p>
                                    <p class="text-sm text-gray-500 truncate">{{ $task->description }}</p>
                                    @if($user->role === 'admin')
                                        <p class="text-xs text-gray-400 mt-1">Attribuée à : {{ $task->user->name ?? 'Inconnu' }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right ml-4">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full transition-colors duration-200
                                    {{ $task->status == 'terminée' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' }}">
                                    {{ $task->status }}
                                </span>
                                <p class="text-xs mt-2 {{ $task->isLate() ? 'text-red-500' : 'text-gray-500' }}">
                                    @if($task->due_date)
                                        {{ $task->due_date->format('d/m/Y') }}
                                        @if($task->isLate())
                                            <span class="font-semibold">(en retard)</span>
                                        @endif
                                    @else
                                        Pas d'échéance
                                    @endif
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
