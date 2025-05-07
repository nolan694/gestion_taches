<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-4">Bienvenue, {{ $user->name }} 👋</h1>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-500 rounded-lg p-4">
                            <p class="text-xl text-white">Total Tâches</p>
                            <p class="text-3xl font-bold text-white">{{ $totalTasks }}</p>
                        </div>
                        <div class="bg-green-500 rounded-lg p-4">
                            <p class="text-xl text-white">Terminées</p>
                            <p class="text-3xl font-bold text-white">{{ $tasksCompleted }}</p>
                        </div>
                        <div class="bg-yellow-500 rounded-lg p-4">
                            <p class="text-xl text-white">En cours</p>
                            <p class="text-3xl font-bold text-white">{{ $tasksInProgress }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
