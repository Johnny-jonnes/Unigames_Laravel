<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use App\Models\Edition;
use Illuminate\Http\Request;

class FaculteController extends Controller
{
    /**
     * Afficher la liste des facultés.
     */
    public function index()
    {
        if (!session('selected_edition_id')) {
            return view('facultes.index', ['facultes' => collect(), 'noEdition' => true]);
        }

        $facultes = Faculte::with('edition')
            ->withCount('equipes')
            ->where('edition_id', session('selected_edition_id'))
            ->orderBy('nom')
            ->get();

        return view('facultes.index', ['facultes' => $facultes, 'noEdition' => false]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $editions = Edition::orderBy('date_debut', 'desc')->get();
        return view('facultes.create', compact('editions'));
    }

    /**
     * Enregistrer une nouvelle faculté.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'universite' => 'required|string|max:255',
            'edition_id' => 'required|exists:editions,id',
        ]);

        Faculte::create($validated);

        return redirect()->route('facultes.index')
            ->with('success', 'Faculté ajoutée avec succès.');
    }

    /**
     * Afficher les détails d'une faculté.
     */
    public function show(Faculte $faculte)
    {
        $faculte->load(['edition', 'equipes.discipline', 'equipes.joueurs']);
        return view('facultes.show', compact('faculte'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Faculte $faculte)
    {
        $editions = Edition::orderBy('date_debut', 'desc')->get();
        return view('facultes.edit', compact('faculte', 'editions'));
    }

    /**
     * Mettre à jour une faculté.
     */
    public function update(Request $request, Faculte $faculte)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'universite' => 'required|string|max:255',
            'edition_id' => 'required|exists:editions,id',
        ]);

        $faculte->update($validated);

        return redirect()->route('facultes.index')
            ->with('success', 'Faculté mise à jour avec succès.');
    }

    /**
     * Supprimer une faculté.
     */
    public function destroy(Faculte $faculte)
    {
        $faculte->delete();

        return redirect()->route('facultes.index')
            ->with('success', 'Faculté supprimée avec succès.');
    }
}
