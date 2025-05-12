@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">
            Tableau de bord - {{ $user->role === 'admin' ? 'Administrateur' : 'Utilisateur' }}
        </h1>

        <!-- Statistiques principales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-sm font-medium text-gray-500">
                    {{ $user->role === 'admin' ? 'Total des tâches (tous utilisateurs)' : 'Mes tâches totales' }}
                </h2>
                <p class="mt-2 text-3xl font-bold text-gray-800">{{ $totalTasks }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-sm font-medium text-gray-500">Tâches terminées</h2>
                <p class="mt-2 text-3xl font-bold text-green-600">{{ $tasksCompleted }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-sm font-medium text-gray-500">Tâches en cours</h2>
                <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $tasksInProgress }}</p>
            </div>
        </div>

        <!-- Autres infos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-sm font-medium text-gray-500">Tâches à faire aujourd'hui</h2>
                <p class="mt-2 text-2xl font-bold text-blue-600">{{ $todaysTasks }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-sm font-medium text-gray-500">Tâches en retard</h2>
                <p class="mt-2 text-2xl font-bold text-red-600">{{ $tasksOverdue }}</p>
            </div>
        </div>

        <!-- Tâches récentes -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Tâches récentes</h2>
            @if($recentTasks->isEmpty())
                <p class="text-gray-500">Aucune tâche récente.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($recentTasks as $task)
                        <li class="py-4 flex items-center justify-between">
                            <div>
                                <p class="text-lg font-medium text-gray-900">{{ $task->name }}</p>
                                <p class="text-sm text-gray-500 truncate max-w-md">{{ $task->description }}</p>
                                @if($user->role === 'admin')
                                    <p class="text-xs text-gray-400 mt-1">Attribuée à : {{ $task->user->name ?? 'Inconnu' }}</p>
                                @endif
                            </div>
                            <div class="text-sm text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $task->status == 'terminée' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $task->status }}
                                </span>
                                <p class="text-gray-500 text-xs mt-1">
                                    @if($task->due_date)
                                        Échéance : {{ $task->due_date->format('d/m/Y') }}
                                    @else
                                        Pas d’échéance
                                    @endif
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
