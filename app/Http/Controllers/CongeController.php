<?php

namespace App\Http\Controllers;

use App\Models\Conge;
use App\Models\Agent;
use App\Models\JourFerie;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CongeController extends Controller
{
    public function index()
    {
        $conges = Conge::with('agent')->latest()->paginate(10);
        return view('conges.index', compact('conges'));
    }

    public function create()
    {
        $agents = Agent::all();
        return view('conges.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'jours_a_prendre' => 'required|integer|min:1',
            'date_cessation' => 'required|date',
            'statut' => 'required|in:en_attente,approuve,refuse',
            'exceptionnel' => 'boolean',
            'deductible' => 'boolean',
        ]);

        // Calcul date de reprise
        $dateReprise = $this->calculerDateReprise(
            $request->date_cessation,
            $request->jours_a_prendre
        );

        $conge = Conge::create([
            ...$request->all(),
            'date_reprise' => $dateReprise,
        ]);

        // Mettre à jour les jours de l'agent
        if ($request->statut === 'approuve' && $request->deductible) {
            $agent = Agent::find($request->agent_id);
            $agent->jours_conges_dus -= $request->jours_a_prendre;
            $agent->save();
        }

        return redirect()->route('conges.index')
            ->with('success', 'Congé ajouté avec succès !');
    }

    public function show(Conge $conge)
    {
        return view('conges.show', compact('conge'));
    }

    public function edit(Conge $conge)
    {
        $agents = Agent::all();
        return view('conges.edit', compact('conge', 'agents'));
    }

    public function update(Request $request, Conge $conge)
    {
        $request->validate([
            'agent_id' => 'required|exists:agents,id',
            'jours_a_prendre' => 'required|integer|min:1',
            'date_cessation' => 'required|date',
            'statut' => 'required|in:en_attente,approuve,refuse',
        ]);

        $dateReprise = $this->calculerDateReprise(
            $request->date_cessation,
            $request->jours_a_prendre
        );

        $conge->update([
            ...$request->all(),
            'date_reprise' => $dateReprise,
        ]);

        return redirect()->route('conges.index')
            ->with('success', 'Congé modifié avec succès !');
    }

    public function destroy(Conge $conge)
    {
        $conge->delete();
        return redirect()->route('conges.index')
            ->with('success', 'Congé supprimé avec succès !');
    }

    // Calcul automatique de la date de reprise
    private function calculerDateReprise($dateCessation, $joursAPrendre)
    {
        $joursFeries = JourFerie::pluck('date')->toArray();
        $date = Carbon::parse($dateCessation)->addDay();

        // Si cessation un vendredi, on commence le lundi
        if ($date->isSaturday()) {
            $date->addDays(2);
        }

        $joursComptes = 0;
        while ($joursComptes < $joursAPrendre) {
            // On saute les dimanches et jours fériés
            if (!$date->isSunday() && !in_array($date->toDateString(), $joursFeries)) {
                $joursComptes++;
            }
            if ($joursComptes < $joursAPrendre) {
                $date->addDay();
            }
        }

        return $date->addDay(); // jour de reprise
    }
}
