<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalTasks = Task::count();
            $tasksCompleted = Task::where('status', 'terminée')->count();
            $tasksInProgress = $totalTasks - $tasksCompleted;
            $tasksOverdue = Task::where('status', '!=', 'terminée')
                                ->whereDate('due_date', '<', now())
                                ->count();
            $todaysTasks = Task::whereDate('due_date', today())->count();
            $recentTasks = Task::latest()->take(5)->get();
        } else {
            $totalTasks = Task::where('user_id', $user->id)->count();
            $tasksCompleted = Task::where('user_id', $user->id)
                                  ->where('status', 'terminée')
                                  ->count();
            $tasksInProgress = $totalTasks - $tasksCompleted;
            $tasksOverdue = Task::where('user_id', $user->id)
                                ->where('status', '!=', 'terminée')
                                ->whereDate('due_date', '<', now())
                                ->count();
            $todaysTasks = Task::where('user_id', $user->id)
                               ->whereDate('due_date', today())
                               ->count();
            $recentTasks = Task::where('user_id', $user->id)
                               ->latest()
                               ->take(5)
                               ->get();
        }

        return view('dashboard', compact(
            'user',
            'totalTasks',
            'tasksCompleted',
            'tasksInProgress',
            'tasksOverdue',
            'todaysTasks',
            'recentTasks'
        ));
    }
}
