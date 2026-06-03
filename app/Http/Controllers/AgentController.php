<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::latest()->paginate(10);
        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule_solde' => 'required|string|unique:agents',
            'lieu_affectation' => 'required|string',
            'type_agent' => 'required|in:titulaire,contractuel',
            'nombre_enfants' => 'required|integer|min:0',
            'date_prise_service' => 'required|date',
        ]);

        // Calcul automatique des jours de congés dus
        $datePrise = Carbon::parse($request->date_prise_service);
        $aujourdhui = Carbon::now();
        $moisTravailles = $datePrise->diffInMonths($aujourdhui);

        // 2 jours par mois, minimum 12 mois pour avoir droit aux congés
        if ($moisTravailles >= 12) {
            $joursConges = 24; // 24 jours de base
            $joursConges += $request->nombre_enfants; // +1 jour par enfant
        } else {
            $joursConges = min($moisTravailles * 2, 24);
        }

        // Maximum 72 jours
        $joursConges = min($joursConges, 72);

        Agent::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'matricule_solde' => $request->matricule_solde,
            'lieu_affectation' => $request->lieu_affectation,
            'type_agent' => $request->type_agent,
            'nombre_enfants' => $request->nombre_enfants,
            'date_prise_service' => $request->date_prise_service,
            'jours_conges_dus' => $joursConges,
            'jours_reportes' => 0,
        ]);

        return redirect()->route('agents.index')
            ->with('success', 'Agent ajouté avec succès ! Jours de congés calculés : ' . $joursConges);
    }

    public function show(Agent $agent)
    {
        $agent->load('conges', 'absences');
        return view('agents.show', compact('agent'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'matricule_solde' => 'required|string|unique:agents,matricule_solde,'.$agent->id,
            'lieu_affectation' => 'required|string',
            'type_agent' => 'required|in:titulaire,contractuel',
            'nombre_enfants' => 'required|integer|min:0',
            'date_prise_service' => 'required|date',
        ]);

        $agent->update($request->all());

        return redirect()->route('agents.index')
            ->with('success', 'Agent modifié avec succès !');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();
        return redirect()->route('agents.index')
            ->with('success', 'Agent supprimé avec succès !');
    }
}
