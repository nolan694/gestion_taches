<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     */
    protected $fillable = [
        'name',
        'description',
        'due_date',
        'status',
        'user_id',  // Assurez-vous de spécifier le user_id si nécessaire
    ];

    /**
     * Les attributs à caster automatiquement.
     */
    protected $casts = [
        'due_date' => 'date', // Pour que la date soit automatiquement castée en objet Carbon
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Une tâche appartient à un utilisateur
    }

    /**
     * Vérifie si la tâche est en retard.
     */
    public function isLate(): bool
    {
        return $this->status !== 'terminée' &&
               $this->due_date &&
               $this->due_date->isPast();
    }
}
