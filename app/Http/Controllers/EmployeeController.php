<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Conge;
use App\Models\Absence;
use App\Models\JourFerie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function dashboard()
    {
        $agent = Auth::user()->agent;

        if (!$agent) {
            return view('employee.dashboard', [
                'agent' => null,
                'conges' => [],
                'absences' => []
            ]);
        }

        $conges = Conge::where('agent_id', $agent->id)->orderBy('created_at', 'desc')->get();
        $absences = Absence::where('agent_id', $agent->id)->orderBy('created_at', 'desc')->get();

        return view('employee.dashboard', compact('agent', 'conges', 'absences'));
    }

    public function showAbsence($id)
    {
        $absence = Absence::with('agent')->findOrFail($id);

        if (Auth::user()->isEmployee() && $absence->agent_id !== Auth::user()->agent_id) {
            abort(403, 'Action non autorisée.');
        }

        return view('absences.show', compact('absence'));
    }

    public function showDemandeConge()
    {
        return view('employee.demande-cong');
    }

    public function storeDemandeConge(Request $request)
    {
        $agent = Auth::user()->agent;

        $request->validate([
            'jours_a_prendre' => 'required|integer|min:1',
            'date_cessation' => 'required|date',
        ]);

        if ($request->jours_a_prendre > $agent->jours_conges_dus) {
            return back()->with('error', 'Le nombre de jours demandés excède votre solde disponible (' . $agent->jours_conges_dus . ' jours).');
        }

        $joursFeries = JourFerie::pluck('date')->map(fn($d) => $d->toDateString())->toArray();
        $dateCessation = Carbon::parse($request->date_cessation);

        if ($dateCessation->isFriday()) {
            $dateCalcul = $dateCessation->copy()->addDays(3);
        } else {
            $dateCalcul = $dateCessation->copy()->addDay();
        }

        $joursAPrendre = $request->jours_a_prendre;
        $joursComptes = 0;
        while ($joursComptes < $joursAPrendre) {
            if (!$dateCalcul->isSunday() && !in_array($dateCalcul->toDateString(), $joursFeries)) {
                $joursComptes++;
            }
            if ($joursComptes < $joursAPrendre) {
                $dateCalcul->addDay();
            }
        }
        $dateReprise = $dateCalcul->addDay()->format('Y-m-d');

        Conge::create([
            'agent_id' => $agent->id,
            'jours_a_prendre' => $request->jours_a_prendre,
            'date_cessation' => $request->date_cessation,
            'date_reprise' => $dateReprise,
            'statut' => 'en_attente',
            'deductible' => true,
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Votre demande de congé a été soumise. Date de reprise prévue : ' . Carbon::parse($dateReprise)->format('d/m/Y'));
    }

    public function showDemandeAbsence()
    {
        return view('employee.demande-absence');
    }

    public function storeDemandeAbsence(Request $request)
    {
        $agent = Auth::user()->agent;

        $request->validate([
            'nombre_jours' => 'required|integer|min:1',
            'motif' => 'required|string|max:255',
            'date_debut' => 'required|date',
        ]);

        $dateDebut = Carbon::parse($request->date_debut);
        $dateFin = $dateDebut->copy()->addDays($request->nombre_jours - 1);

        // Motifs non déductibles des jours de congés (exceptionnels)
        $motifsNonDeductibles = ['mariage', 'bapteme', 'deces'];
        $deductible = !in_array($request->motif, $motifsNonDeductibles);

        Absence::create([
            'agent_id' => $agent->id,
            'nombre_jours' => $request->nombre_jours,
            'date_debut' => $request->date_debut,
            'date_fin' => $dateFin->format('Y-m-d'),
            'motif' => $request->motif,
            'statut' => 'en_attente',
            'deductible' => $deductible,
        ]);

        return redirect()->route('employee.dashboard')->with('success', 'Votre demande d\'absence a été enregistrée.');
    }
}
