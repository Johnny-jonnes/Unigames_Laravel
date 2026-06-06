<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use Illuminate\Http\Request;

class DisciplineController extends Controller
{
    /**
     * Afficher la liste des disciplines.
     */
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'nom');
        $direction = $request->get('direction', 'asc');

        $query = Discipline::withCount(['equipes', 'matchs']);

        if ($sort === 'nom') {
            $query->orderBy('nom', $direction);
        } elseif ($sort === 'equipes_count') {
            $query->orderBy('equipes_count', $direction);
        } elseif ($sort === 'matchs_count') {
            $query->orderBy('matchs_count', $direction);
        } else {
            $query->orderBy('nom', 'asc');
        }

        $disciplines = $query->get();

        return view('disciplines.index', compact('disciplines', 'sort', 'direction'));
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return view('disciplines.create');
    }

    /**
     * Enregistrer une nouvelle discipline.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_joueurs_par_equipe' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Discipline::create($validated);

        return redirect()->route('disciplines.index')
            ->with('success', 'Discipline ajoutée avec succès.');
    }

    /**
     * Afficher les détails d'une discipline.
     */
    public function show(Discipline $discipline)
    {
        $discipline->load(['equipes.faculte', 'matchs.equipeA', 'matchs.equipeB']);
        return view('disciplines.show', compact('discipline'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Discipline $discipline)
    {
        return view('disciplines.edit', compact('discipline'));
    }

    /**
     * Mettre à jour une discipline.
     */
    public function update(Request $request, Discipline $discipline)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'nombre_joueurs_par_equipe' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $discipline->update($validated);

        return redirect()->route('disciplines.index')
            ->with('success', 'Discipline mise à jour avec succès.');
    }

    /**
     * Supprimer une discipline.
     */
    public function destroy(Discipline $discipline)
    {
        $discipline->delete();

        return redirect()->route('disciplines.index')
            ->with('success', 'Discipline supprimée avec succès.');
    }
}
