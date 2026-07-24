<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'agent_id',
        'nombre_jours',
        'date_debut',
        'date_fin',
        'motif',
        'statut',
        'deductible',   // Ajouté pour correspondre à votre vue
        'commentaire',  // Ajouté pour correspondre à votre vue
    ];

    /**
     * Transtypage des attributs.
     * Cela permet d'utiliser ->format('d/m/Y') directement dans Blade sans erreur !
     */
    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /**
     * Relation avec l'Agent
     */
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
