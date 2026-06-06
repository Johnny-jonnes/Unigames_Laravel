<?php

namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\Equipe;
use App\Models\Discipline;
use Illuminate\Http\Request;

class JoueurController extends Controller
{
    /**
     * Afficher la liste des joueurs.
     */
    public function index(Request $request)
    {
        if (!session('selected_edition_id')) {
            return view('joueurs.index', ['equipesWithJoueurs' => collect(), 'noEdition' => true]);
        }

        $equipesWithJoueurs = Equipe::with(['joueurs', 'faculte', 'discipline'])
            ->withCount('joueurs')
            ->where('edition_id', session('selected_edition_id'))
            ->orderBy('nom')
            ->get();

        return view('joueurs.index', ['equipesWithJoueurs' => $equipesWithJoueurs, 'noEdition' => false]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        $disciplines = Discipline::orderBy('nom')->get();
        $equipes = Equipe::with(['faculte', 'discipline'])->orderBy('nom')->get();
        return view('joueurs.create', compact('equipes', 'disciplines'));
    }

    /**
     * Enregistrer un nouveau joueur.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'numero' => 'nullable|integer|min:1',
            'sexe' => 'required|string|in:M,F',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        if (array_key_exists('numero', $validated)) {
            $validated['numero_maillot'] = $validated['numero'];
            unset($validated['numero']);
        }

        Joueur::create($validated);

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur ajouté avec succès.');
    }

    /**
     * Afficher les détails d'un joueur.
     */
    public function show(Joueur $joueur)
    {
        $joueur->load(['equipe.faculte', 'equipe.discipline']);
        return view('joueurs.show', compact('joueur'));
    }

    /**
     * Afficher le formulaire d'édition.
     */
    public function edit(Joueur $joueur)
    {
        $disciplines = Discipline::orderBy('nom')->get();
        $equipes = Equipe::with(['faculte', 'discipline'])->orderBy('nom')->get();
        return view('joueurs.edit', compact('joueur', 'equipes', 'disciplines'));
    }

    /**
     * Mettre à jour un joueur.
     */
    public function update(Request $request, Joueur $joueur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'numero' => 'nullable|integer|min:1',
            'numero_maillot' => 'nullable|integer|min:1',
            'poste' => 'nullable|string|max:255',
            'equipe_id' => 'required|exists:equipes,id',
        ]);

        if (array_key_exists('numero', $validated)) {
            $validated['numero_maillot'] = $validated['numero'];
            unset($validated['numero']);
        }

        $joueur->update($validated);

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur mis à jour avec succès.');
    }

    /**
     * Supprimer un joueur.
     */
    public function destroy(Joueur $joueur)
    {
        $joueur->delete();

        return redirect()->route('joueurs.index')
            ->with('success', 'Joueur supprimé avec succès.');
    }
}
