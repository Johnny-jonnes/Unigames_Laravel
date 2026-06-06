<?php

namespace App\Http\Controllers;

use App\Models\Match_;
use App\Models\Equipe;
use App\Models\Discipline;
use App\Models\Edition;
use Illuminate\Http\Request;

class MatchController extends Controller
{
    /**
     * Afficher la liste des matchs.
     */
    public function index()
    {
        if (!session('selected_edition_id')) {
            return view('matchs.index', ['disciplinesWithMatchs' => collect(), 'noEdition' => true]);
        }

        $disciplinesWithMatchs = Discipline::with(['matchs' => function($q) {
            $q->where('edition_id', session('selected_edition_id'))
              ->with(['equipeA.faculte', 'equipeB.faculte', 'edition'])
              ->orderBy('date_match', 'desc');
        }])->get();

        $selectedEdition = \App\Models\Edition::find(session('selected_edition_id'));

        return view('matchs.index', ['disciplinesWithMatchs' => $disciplinesWithMatchs, 'noEdition' => false, 'selectedEdition' => $selectedEdition]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $equipes = Equipe::with(['faculte', 'discipline'])->orderBy('nom')->get();
        $disciplines = Discipline::orderBy('nom')->get();
        $editions = Edition::orderBy('date_debut', 'desc')->get();
        $phases = ['Poules', 'Quarts de Finale', 'Demi-Finales', 'Petite Finale', 'Finale'];

        return view('matchs.create', compact('equipes', 'disciplines', 'editions', 'phases'));
    }

    /**
     * Enregistrer un nouveau match.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipe_a_id' => 'required|exists:equipes,id|different:equipe_b_id',
            'equipe_b_id' => 'required|exists:equipes,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'edition_id' => 'required|exists:editions,id',
            'date_match' => 'required|date',
            'lieu' => 'nullable|string|max:255',
            'phase' => 'required|string|max:255',
        ]);

        $edition = \App\Models\Edition::find($validated['edition_id']);
        if ($edition && $edition->statut === 'terminee') {
            return back()->withInput()->withErrors(['edition_id' => 'Il est interdit de programmer un match pour une édition terminée.']);
        }

        $validated['statut'] = 'planifie';

        Match_::create($validated);

        return redirect()->route('matchs.index')
            ->with('success', 'Match planifié avec succès.');
    }

    /**
     * Afficher les détails d'un match.
     */
    public function show(int $id)
    {
        $match = Match_::with(['equipeA.faculte', 'equipeB.faculte', 'discipline', 'edition'])->findOrFail($id);
        return view('matchs.show', compact('match'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(int $id)
    {
        $match = Match_::findOrFail($id);
        $equipes = Equipe::with(['faculte', 'discipline'])->orderBy('nom')->get();
        $disciplines = Discipline::orderBy('nom')->get();
        $editions = Edition::orderBy('date_debut', 'desc')->get();
        $phases = ['Poules', 'Quarts de Finale', 'Demi-Finales', 'Petite Finale', 'Finale'];

        return view('matchs.edit', compact('match', 'equipes', 'disciplines', 'editions', 'phases'));
    }

    /**
     * Mettre à jour un match.
     */
    public function update(Request $request, int $id)
    {
        $match = Match_::findOrFail($id);

        $validated = $request->validate([
            'equipe_a_id' => 'required|exists:equipes,id|different:equipe_b_id',
            'equipe_b_id' => 'required|exists:equipes,id',
            'discipline_id' => 'required|exists:disciplines,id',
            'edition_id' => 'required|exists:editions,id',
            'date_match' => 'required|date',
            'lieu' => 'nullable|string|max:255',
            'phase' => 'required|string|max:255',
        ]);

        $match->update($validated);

        return redirect()->route('matchs.index')
            ->with('success', 'Match mis à jour avec succès.');
    }

    /**
     * Saisir le score d'un match.
     */
    public function saisirScore(Request $request, int $id)
    {
        $match = Match_::with(['equipeA.joueurs', 'equipeB.joueurs'])->findOrFail($id);

        $validated = $request->validate([
            'score_a' => 'required|integer|min:0',
            'score_b' => 'required|integer|min:0',
            'buteurs_a' => 'nullable|array',
            'buteurs_a.*.id' => 'required|exists:joueurs,id',
            'buteurs_a.*.nb_buts' => 'required|integer|min:1',
            'buteurs_b' => 'nullable|array',
            'buteurs_b.*.id' => 'required|exists:joueurs,id',
            'buteurs_b.*.nb_buts' => 'required|integer|min:1',
        ]);

        // Préparer les données des buteurs pour le JSON
        $buteursData = [
            'equipe_a' => $validated['buteurs_a'] ?? [],
            'equipe_b' => $validated['buteurs_b'] ?? [],
        ];

        $match->update([
            'score_a' => $validated['score_a'],
            'score_b' => $validated['score_b'],
            'buteurs' => $buteursData,
            'statut' => 'joue',
        ]);

        // Mettre à jour le compteur global de buts des joueurs
        if (!empty($validated['buteurs_a'])) {
            foreach ($validated['buteurs_a'] as $data) {
                \App\Models\Joueur::where('id', $data['id'])->increment('buts', $data['nb_buts']);
            }
        }
        if (!empty($validated['buteurs_b'])) {
            foreach ($validated['buteurs_b'] as $data) {
                \App\Models\Joueur::where('id', $data['id'])->increment('buts', $data['nb_buts']);
            }
        }

        return redirect()->route('matchs.show', $match->id)
            ->with('success', 'Score et buteurs enregistrés avec succès.');
    }

    /**
     * Supprimer un match.
     */
    public function destroy(int $id)
    {
        $match = Match_::findOrFail($id);
        $match->delete();

        return redirect()->route('matchs.index')
            ->with('success', 'Match supprimé avec succès.');
    }
}
