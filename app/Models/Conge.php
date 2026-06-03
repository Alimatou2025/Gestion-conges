<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conge extends Model
{
    protected $fillable = [
        'agent_id',
        'jours_a_prendre',
        'date_cessation',
        'date_reprise',
        'statut',
        'commentaire',
        'exceptionnel',
        'deductible',
    ];

    protected $casts = [
        'date_cessation' => 'date',
        'date_reprise' => 'date',
        'exceptionnel' => 'boolean',
        'deductible' => 'boolean',
    ];

    // Un congé appartient à un agent
    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

}
