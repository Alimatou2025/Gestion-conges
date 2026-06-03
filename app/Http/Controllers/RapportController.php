<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportController extends Controller
{
    public function index()
    {
        return view('rapports.index');
    }

    public function generer(Request $request)
    {
        $type = $request->type;
        $agents = Agent::query();

        if ($type == 'direction') {
            $agents = $agents->where('lieu_affectation', 'like', '%Direction%');
        } elseif ($type == 'ufr') {
            $agents = $agents->where('lieu_affectation', 'like', '%UFR%');
        } elseif ($type == 'rectorat') {
            $agents = $agents->where(function($q) {
                $q->where('lieu_affectation', 'like', '%Rectorat%')
                  ->orWhere('lieu_affectation', 'like', '%Vice-Recteur%');
            });
        }

        $agents = $agents->get();

        return view('rapports.generer', compact('agents', 'type'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->type;
        $agents = Agent::query();

        if ($type == 'direction') {
            $agents = $agents->where('lieu_affectation', 'like', '%Direction%');
        } elseif ($type == 'ufr') {
            $agents = $agents->where('lieu_affectation', 'like', '%UFR%');
        } elseif ($type == 'rectorat') {
            $agents = $agents->where(function($q) {
                $q->where('lieu_affectation', 'like', '%Rectorat%')
                  ->orWhere('lieu_affectation', 'like', '%Vice-Recteur%');
            });
        }

        $agents = $agents->get();

        $pdf = Pdf::loadView('rapports.pdf', compact('agents', 'type'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('rapport-conges-'.$type.'.pdf');
    }
}
