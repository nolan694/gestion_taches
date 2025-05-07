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
                    <h1 class="text-2xl font-bold mb-4">Bienvenue sur l'application de gestion de tâches</h1>
                    <p class="mb-2">Connecté en tant que : <strong>{{ Auth::user()->role }}</strong></p>
                    <p class="mb-2">Nom d'utilisateur : <strong>{{ Auth::user()->name }}</strong></p>

                    @if(Auth::user()->role === 'admin')
                        <p class="text-green-500 mt-4">Vous êtes administrateur. Vous avez un accès complet aux utilisateurs et aux tâches.</p>
                    @else
                        <p class="text-blue-500 mt-4">Vous êtes un utilisateur standard. Vous pouvez gérer uniquement vos propres tâches.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
