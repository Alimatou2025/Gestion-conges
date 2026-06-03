<?php

namespace App\Http\Controllers;

use App\Models\JourFerie;
use Illuminate\Http\Request;

class JourFerieController extends Controller
{
    public function index()
    {
        $joursFeries = JourFerie::orderBy('date')->paginate(10);
        return view('jours-feries.index', compact('joursFeries'));
    }

    public function create()
    {
        return view('jours-feries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date',
            'annuel' => 'boolean',
        ]);

        JourFerie::create($request->all());

        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié ajouté avec succès !');
    }

    public function show(JourFerie $jourFerie)
    {
        return view('jours-feries.show', compact('jourFerie'));
    }

    public function edit(JourFerie $jourFerie)
    {
        return view('jours-feries.edit', compact('jourFerie'));
    }

    public function update(Request $request, JourFerie $jourFerie)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'date' => 'required|date',
            'annuel' => 'boolean',
        ]);

        $jourFerie->update($request->all());

        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié modifié avec succès !');
    }

    public function destroy(JourFerie $jourFerie)
    {
        $jourFerie->delete();
        return redirect()->route('jours-feries.index')
            ->with('success', 'Jour férié supprimé avec succès !');
    }
}
