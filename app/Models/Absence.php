<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
   protected $fillable = [
        'agent_id',
        'nombre_jours',
        'date_debut',
        'date_fin',
        'motif',
        'deductible',
        'commentaire',
    ];

    protected $casts = [
        'date_debut' => 'date',
        'date_fin' => 'date',
        'deductible' => 'boolean',
    ];

    // Une absence appartient à un agent
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}
