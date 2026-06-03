<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\Agent;
use Illuminate\Http\Request;

class AbsenceController extends Controller
{
    public function index()
    {
        $absences = Absence::with('agent')->latest()->paginate(10);
        return view('absences.index', compact('absences'));
    }

    public function create()
    {
        $agents = Agent::all();
        return view('absences.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'nombre_jours' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'motif' => 'required|string',
            'deductible' => 'boolean',
        ]);

        Absence::create($request->all());

        // Déduire automatiquement si déductible
        if ($request->deductible) {
            $agent = Agent::find($request->agent_id);
            $agent->jours_conges_dus -= $request->nombre_jours;
            $agent->save();
        }

        return redirect()->route('absences.index')
            ->with('success', 'Absence ajoutée avec succès !');
    }

    public function show(Absence $absence)
    {
        return view('absences.show', compact('absence'));
    }

    public function edit(Absence $absence)
    {
        $agents = Agent::all();
        return view('absences.edit', compact('absence', 'agents'));
    }

    public function update(Request $request, Absence $absence)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'nombre_jours' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'motif' => 'required|string',
        ]);

        $absence->update($request->all());

        return redirect()->route('absences.index')
            ->with('success', 'Absence modifiée avec succès !');
    }

    public function destroy(Absence $absence)
    {
        $absence->delete();
        return redirect()->route('absences.index')
            ->with('success', 'Absence supprimée avec succès !');
    }
}
