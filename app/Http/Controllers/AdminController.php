<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Conge;
use App\Models\Absence;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAgents = Agent::count();

        $congesEnAttente = Conge::where('statut', 'en_attente')->with('agent')->get();
        $absencesEnAttente = Absence::where('statut', 'en_attente')->with('agent')->get();

        $allAgents = Agent::all();

        return view('admin.dashboard', compact('totalAgents', 'congesEnAttente', 'absencesEnAttente', 'allAgents'));
    }

    public function showAbsence($id)
    {
        $absence = Absence::with('agent')->findOrFail($id);
        return view('absences.show', compact('absence'));
    }

    public function validerConge($id)
    {
        $conge = Conge::findOrFail($id);
        $agent = Agent::findOrFail($conge->agent_id);

        if ($agent->jours_conges_dus >= $conge->jours_a_prendre) {
            $agent->jours_conges_dus -= $conge->jours_a_prendre;
        } else {
            $agent->jours_conges_dus = 0;
        }
        $agent->save();

        $conge->statut = 'approuve';
        $conge->save();

        return redirect()->route('admin.dashboard')->with('success', 'La demande de congé a été validée avec succès.');
    }

    public function refuserConge($id)
    {
        $conge = Conge::findOrFail($id);
        $conge->statut = 'refuse';
        $conge->save();

        return redirect()->route('admin.dashboard')->with('error', 'La demande de congé a été refusée.');
    }

    public function validerAbsence($id)
    {
        $absence = Absence::findOrFail($id);
        $agent = Agent::findOrFail($absence->agent_id);

        if ($absence->deductible) {
            if ($agent->jours_conges_dus >= $absence->nombre_jours) {
                $agent->jours_conges_dus -= $absence->nombre_jours;
            } else {
                $agent->jours_conges_dus = 0;
            }
            $agent->save();
        }

        $absence->statut = 'approuve';
        $absence->save();

        return redirect()->route('admin.dashboard')->with('success', 'La demande d\'absence a été validée avec succès.');
    }

    public function refuserAbsence($id)
    {
        $absence = Absence::findOrFail($id);
        $absence->statut = 'refuse';
        $absence->save();

        return redirect()->route('admin.dashboard')->with('error', 'La demande d\'absence a été refusée.');
    }
}
