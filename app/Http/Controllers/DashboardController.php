<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer l'utilisateur actuellement connecté
        $user = Auth::user();

        // Si l'utilisateur est un admin, on récupère les tâches de tous les utilisateurs
        if ($user->role === 'admin') {
            // Nombre total de tâches dans la base
            $totalTasks = Task::count();
            // Nombre de tâches terminées
            $tasksCompleted = Task::where('status', 'terminée')->count();
            // Nombre de tâches en cours
            $tasksInProgress = $totalTasks - $tasksCompleted;
        } else {
            // Si l'utilisateur est un utilisateur standard, on récupère ses propres tâches
            $totalTasks = Task::where('user_id', $user->id)->count();
            // Nombre de tâches terminées de l'utilisateur
            $tasksCompleted = Task::where('user_id', $user->id)
                                  ->where('status', 'terminée')
                                  ->count();
            // Nombre de tâches en cours pour l'utilisateur
            $tasksInProgress = $totalTasks - $tasksCompleted;
        }

        // Renvoyer la vue avec les données
        return view('dashboard', compact(
            'user',
            'totalTasks',
            'tasksCompleted',
            'tasksInProgress'
        ));
    }
}
