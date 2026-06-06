<?php

namespace App\Http\Controllers;

use App\Models\Edition;
use App\Models\Faculte;
use App\Models\Discipline;
use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\Match_;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Afficher le tableau de bord principal.
     */
    public function index(Request $request)
    {
        // 1. Récupérer toutes les éditions pour le sélecteur
        $editions = Edition::orderBy('date_debut', 'desc')->get();
        
        // 2. Déterminer l'édition sélectionnée (pas de défaut)
        if ($request->has('edition_id')) {
            $selectedEditionId = $request->input('edition_id');
            session(['selected_edition_id' => $selectedEditionId]);
        } else {
            $selectedEditionId = session('selected_edition_id');
        }
        
        if (!$selectedEditionId) {
            return view('dashboard', [
                'editions' => $editions,
                'selectedEditionId' => null,
                'editionEnCours' => null,
                'stats' => null,
                'prochainsMatchs' => collect(),
                'derniersResultats' => collect(),
                'meilleursButeurs' => collect(),
                'tousLesMatchs' => collect(),
                'arborescence' => []
            ]);
        }

        $editionEnCours = Edition::find($selectedEditionId);

        // 3. Filtrer toutes les statistiques par l'édition sélectionnée
        $stats = [
            'editions' => Edition::count(), // Global
            'facultes' => Faculte::where('edition_id', $selectedEditionId)->count(),
            'disciplines' => Discipline::count(), // Global
            'equipes' => Equipe::where('edition_id', $selectedEditionId)->count(),
            'joueurs' => Joueur::whereHas('equipe', function($q) use ($selectedEditionId) {
                $q->where('edition_id', $selectedEditionId);
            })->count(),
            'matchs_total' => Match_::where('edition_id', $selectedEditionId)->count(),
            'matchs_joues' => Match_::where('edition_id', $selectedEditionId)->where('statut', 'joue')->count(),
            'matchs_planifies' => Match_::where('edition_id', $selectedEditionId)->where('statut', 'planifie')->count(),
        ];

        $prochainsMatchs = Match_::with(['equipeA.faculte', 'equipeB.faculte', 'discipline'])
            ->where('edition_id', $selectedEditionId)
            ->where('statut', 'planifie')
            ->orderBy('date_match', 'asc')
            ->take(5)
            ->get();

        $derniersResultats = Match_::with(['equipeA.faculte', 'equipeB.faculte', 'discipline'])
            ->where('edition_id', $selectedEditionId)
            ->where('statut', 'joue')
            ->orderBy('date_match', 'desc')
            ->take(5)
            ->get();

        $meilleursButeurs = Joueur::with('equipe.faculte')
            ->whereHas('equipe', function($q) use ($selectedEditionId) {
                $q->where('edition_id', $selectedEditionId);
            })
            ->orderBy('buts', 'desc')
            ->take(5)
            ->get();

        // Récupérer tous les matchs pour l'arborescence (Demi et Finale)
        $tousLesMatchs = Match_::with(['equipeA', 'equipeB', 'discipline'])
            ->where('edition_id', $selectedEditionId)
            ->whereIn('phase', ['Demi', 'Finale'])
            ->get();

        $arborescence = [];
        foreach ($tousLesMatchs as $match) {
            $arborescence[$match->discipline->nom][$match->phase][] = $match;
        }

        return view('dashboard', compact(
            'stats',
            'prochainsMatchs',
            'derniersResultats',
            'meilleursButeurs',
            'editionEnCours',
            'editions',
            'selectedEditionId',
            'tousLesMatchs',
            'arborescence'
        ));
    }
}
