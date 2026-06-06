<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\Discipline;
use App\Models\Edition;
use App\Models\Joueur;
use Illuminate\Http\Request;

class ClassementController extends Controller
{
    /**
     * Afficher la page de classement.
     */
    public function index(Request $request)
    {
        if (!session('selected_edition_id')) {
            return view('classements.index', [
                'disciplines' => collect(),
                'editions' => collect(),
                'classement' => collect(),
                'meilleursButeurs' => collect(),
                'disciplineId' => null,
                'editionId' => null,
                'noEdition' => true,
            ]);
        }

        $disciplines = Discipline::orderBy('nom')->get();
        $editions = Edition::orderBy('date_debut', 'desc')->get();

        $disciplineId = $request->get('discipline_id');
        $editionId = session('selected_edition_id');

        $classement = collect();

        if ($disciplineId) {
            $equipes = Equipe::with(['faculte', 'discipline'])
                ->where('discipline_id', $disciplineId)
                ->where('edition_id', $editionId)
                ->get();

            // Calculer le classement
            $classement = $equipes->map(function ($equipe) {
                return [
                    'equipe' => $equipe,
                    'points' => $equipe->points,
                    'matchs_joues' => $equipe->matchs_joues,
                    'victoires' => $equipe->victoires,
                    'nuls' => $equipe->nuls,
                    'defaites' => $equipe->defaites,
                    'buts_marques' => $equipe->buts_marques,
                    'buts_encaisses' => $equipe->buts_encaisses,
                    'difference' => $equipe->getDifferenceButs(),
                ];
            })->sortByDesc('points')->sortByDesc('difference')->values();
        }

        $meilleursButeurs = Joueur::with(['equipe.faculte', 'equipe.discipline'])
            ->whereHas('equipe', fn($q) => $q->where('edition_id', $editionId))
            ->orderBy('buts', 'desc')
            ->take(10)
            ->get();

        return view('classements.index', [
            'disciplines' => $disciplines,
            'editions' => $editions,
            'classement' => $classement,
            'meilleursButeurs' => $meilleursButeurs,
            'disciplineId' => $disciplineId,
            'editionId' => $editionId,
            'noEdition' => false,
        ]);
    }
}
