<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // Affiche la liste des tâches avec filtrage et pagination
    public function index(Request $request)
{
    $query = \App\Models\Task::query();

    // Admin peut voir toutes les tâches, l'utilisateur voit ses propres tâches
    if (auth()->user()->role !== 'admin') {
        $query->where('user_id', auth()->id());
    }

    // Filtrage par statut, échéance, recherche
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    if ($request->filled('due_date')) {
        $query->whereDate('due_date', '<=', $request->due_date);
    }

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    // Filtrage par utilisateur pour l'admin
    if ($request->filled('user_id') && auth()->user()->role === 'admin') {
        $query->where('user_id', $request->user_id);
    }

    // Récupérer les utilisateurs pour le filtre (uniquement pour l'admin)
    $users = \App\Models\User::all();

    // Trier et paginer les tâches
    $tasks = $query->orderBy('due_date', 'asc')->paginate(10);

    // Passer les tâches et utilisateurs à la vue
    return view('tasks.index', compact('tasks', 'users'));
}



    // terminer une tâche
    public function complete(Task $task)
    {
        // On s'assure que seul le propriétaire ou un admin peut marquer la tâche comme terminée
        if (auth()->user()->role !== 'admin' && $task->user_id !== auth()->id()) {
            return redirect()->route('tasks.index')->with('error', 'Accès refusé.');
        }

        $task->status = 'terminée';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Tâche marquée comme terminée.');
    }


    // Afficher la page de création de tâche
    public function create()
{
    $users = [];

    if (auth()->user()->role === 'admin') {
        $users = \App\Models\User::all();
    }

    return view('tasks.create', compact('users'));
}

    // Enregistrer une nouvelle tâche
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'due_date' => 'required|date',
        'user_id' => auth()->user()->role === 'admin' ? 'required|exists:users,id' : ''
    ]);

    $task = new Task();
    $task->name = $validated['name'];
    $task->description = $validated['description'];
    $task->due_date = $validated['due_date'];
    $task->status = 'en cours';

    // Admin peut choisir l'utilisateur, sinon c'est l'utilisateur connecté
    $task->user_id = auth()->user()->role === 'admin'
        ? $validated['user_id']
        : auth()->id();

    $task->save();

    return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès.');
}


    // Afficher le formulaire de modification d'une tâche
    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Mettre à jour une tâche
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        $task->update($request->only(['name', 'description', 'due_date', 'status']));


        return redirect()->route('tasks.index');
    }

    // Marquer une tâche comme terminée
    public function markAsCompleted(Task $task)
    {
        $task->update(['status' => 'terminée']);

        return redirect()->route('tasks.index');
    }

    // Supprimer une tâche
    public function destroy(Task $task)
    {
        // Vérification des permissions : seul l'admin ou le propriétaire peut supprimer
        if (auth()->user()->role !== 'admin' && $task->user_id !== auth()->id()) {
            return redirect()->route('tasks.index')->with('error', 'Accès refusé.');
        }

        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée avec succès.');
    }
}
