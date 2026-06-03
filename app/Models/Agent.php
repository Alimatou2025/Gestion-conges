<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'matricule_solde',
        'lieu_affectation',
        'type_agent',
        'nombre_enfants',
        'date_prise_service',
        'jours_conges_dus',
        'jours_reportes',
    ];

    protected $casts = [
        'date_prise_service' => 'date',
    ];

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
