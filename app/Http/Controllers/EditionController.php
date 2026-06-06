<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use Illuminate\Http\Request;

class EditionController extends Controller
{
    /**
     * Afficher la liste des éditions.
     */
    public function index()
    {
        $editions = Edition::withCount(['facultes', 'equipes', 'matchs'])
            ->orderBy('date_debut', 'desc')
            ->get();

        return view('editions.index', compact('editions'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('editions.create');
    }

    /**
     * Enregistrer une nouvelle édition.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'required|in:a_venir,en_cours,terminee',
        ]);

        Edition::create($validated);

        return redirect()->route('editions.index')
            ->with('success', 'Édition créée avec succès.');
    }

    /**
     * Afficher les détails d'une édition.
     */
    public function show(Edition $edition)
    {
        $edition->load(['facultes', 'equipes.discipline', 'equipes.faculte', 'matchs.equipeA', 'matchs.equipeB', 'matchs.discipline']);

        return view('editions.show', compact('edition'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Edition $edition)
    {
        return view('editions.edit', compact('edition'));
    }

    /**
     * Mettre à jour une édition.
     */
    public function update(Request $request, Edition $edition)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'lieu' => 'required|string|max:255',
            'description' => 'nullable|string',
            'statut' => 'required|in:a_venir,en_cours,terminee',
        ]);

        $edition->update($validated);

        return redirect()->route('editions.index')
            ->with('success', 'Édition mise à jour avec succès.');
    }

    /**
     * Afficher l'arbre du tournoi (Bracket).
     */
    public function arbre(Edition $edition)
    {
        $edition->load(['matchs.equipeA', 'matchs.equipeB', 'matchs.discipline']);
        
        // Grouper les matchs par discipline
        $disciplines = $edition->matchs->groupBy('discipline_id');
        
        $disciplinesData = [];
        foreach ($disciplines as $disciplineId => $matchs) {
            $discipline = \App\Models\Discipline::find($disciplineId);
            $matchsByPhase = $matchs->groupBy('phase');
            
            $disciplinesData[] = [
                'discipline' => $discipline,
                'phases' => $matchsByPhase
            ];
        }


        return view('editions.arbre', compact('edition', 'disciplinesData'));
    }

    /**
     * Supprimer une édition.
     */
    public function destroy(Edition $edition)
    {
        $edition->delete();

        return redirect()->route('editions.index')
            ->with('success', 'Édition supprimée avec succès.');
    }
}
