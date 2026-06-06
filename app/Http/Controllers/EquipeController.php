<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Faculte;
use App\Models\Discipline;
use App\Models\Edition;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    /**
     * Afficher la liste des équipes.
     */
    public function index()
    {
        if (!session('selected_edition_id')) {
            return view('equipes.index', ['disciplinesWithEquipes' => collect(), 'noEdition' => true]);
        }

        $disciplinesWithEquipes = Discipline::with(['equipes' => function($q) {
            $q->where('edition_id', session('selected_edition_id'))
              ->with(['faculte', 'edition'])
              ->withCount('joueurs')
              ->orderBy('nom');
        }])->get();

        return view('equipes.index', ['disciplinesWithEquipes' => $disciplinesWithEquipes, 'noEdition' => false]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $facultes = Faculte::orderBy('nom')->get();
        $disciplines = Discipline::orderBy('nom')->get();
        $editions = Edition::orderBy('date_debut', 'desc')->get();

        return view('equipes.create', compact('facultes', 'disciplines', 'editions'));
    }

    /**
     * Enregistrer une nouvelle équipe.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte_id' => 'required|exists:facultes,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'edition_id' => 'required|exists:editions,id',
        ]);

        Equipe::create($validated);

        return redirect()->route('equipes.index')
            ->with('success', 'Équipe inscrite avec succès.');
    }

    /**
     * Afficher les détails d'une équipe.
     */
    public function show(Equipe $equipe)
    {
        $equipe->load(['faculte', 'discipline', 'edition', 'joueurs']);
        return view('equipes.show', compact('equipe'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Equipe $equipe)
    {
        $facultes = Faculte::orderBy('nom')->get();
        $disciplines = Discipline::orderBy('nom')->get();
        $editions = Edition::orderBy('date_debut', 'desc')->get();

        return view('equipes.edit', compact('equipe', 'facultes', 'disciplines', 'editions'));
    }

    /**
     * Mettre à jour une équipe.
     */
    public function update(Request $request, Equipe $equipe)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'faculte_id' => 'required|exists:facultes,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'edition_id' => 'required|exists:editions,id',
        ]);

        $equipe->update($validated);

        return redirect()->route('equipes.index')
            ->with('success', 'Équipe mise à jour avec succès.');
    }

    /**
     * Supprimer une équipe.
     */
    public function destroy(Equipe $equipe)
    {
        $equipe->delete();

        return redirect()->route('equipes.index')
            ->with('success', 'Équipe supprimée avec succès.');
    }
}
