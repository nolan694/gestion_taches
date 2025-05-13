@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow-lg mt-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">📌 Détails de la tâche</h1>

    <div class="space-y-4 text-gray-700">
        <div>
            <span class="font-semibold">Nom :</span>
            {{ $task->name }}
        </div>

        <div>
            <span class="font-semibold">Description :</span>
            <p>{{ $task->description }}</p>
        </div>

        <div>
            <span class="font-semibold">Date d’échéance :</span>
            {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
        </div>

        <div>
            <span class="font-semibold">Statut :</span>
            <span class="inline-block px-2 py-1 text-sm rounded
                {{ $task->status === 'terminée' ? 'bg-green-100 text-green-800' : ($task->status === 'en cours' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($task->status) }}
            </span>
        </div>

        <div>
            <span class="font-semibold">Assignée à :</span>
            {{ $task->user->name ?? 'Non assignée' }}
        </div>

        @if($task && $task->created_at)
    <div>
        <span class="font-semibold">Créée le :</span>
        {{ $task->created_at->format('d/m/Y à H:i') }}
    </div>
@else
    <div>
        <span class="font-semibold">Créée le :</span>
        Non disponible
    </div>
@endif
    </div>

    <div class="mt-6">
        <a href="{{ route('tasks.index') }}" class="text-blue-600 hover:underline">← Retour à la liste des tâches</a>
    </div>
</div>
@endsection
