<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue - Application de Gestion de Tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col justify-center items-center p-6">
        <div class="text-center max-w-3xl">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Application de Gestion de Tâches</h1>
            <p class="text-lg mb-6">
                Bienvenue dans notre application développée dans le cadre du BTS SIO option SLAM.
                Cette plateforme permet de gérer efficacement des tâches selon le rôle de l'utilisateur.
            </p>

            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Fonctionnalités Clés</h2>
                <ul class="list-disc list-inside text-left space-y-2">
                    <li><strong>Authentification sécurisée</strong> (inscription, connexion, déconnexion)</li>
                    <li><strong>Gestion des rôles</strong> : administrateur / utilisateur</li>
                    <li><strong>CRUD des tâches</strong> : créer, modifier, supprimer, marquer comme terminée</li>
                    <li><strong>Visualisation filtrée</strong> par statut, date d'échéance</li>
                    <li><strong>Pagination</strong> des tâches</li>
                    <li><strong>Gestion des utilisateurs</strong> (admin uniquement)</li>
                </ul>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6 mb-8">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Technologies Utilisées</h2>
                <ul class="list-disc list-inside text-left space-y-2">
                    <li><strong>Laravel</strong> 12</li>
                    <li><strong>Laravel Breeze</strong> avec Blade & Tailwind CSS</li>
                    <li><strong>MySQL</strong></li>
                    <li><strong>Outils</strong> : Composer, NPM, VS Code, Git</li>
                </ul>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Se connecter</a>
                <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-200 text-blue-600 rounded-lg hover:bg-gray-300">S'inscrire</a>
            </div>
        </div>
    </div>
</body>
</html>
