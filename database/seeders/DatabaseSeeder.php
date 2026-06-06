<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Edition;
use App\Models\Faculte;
use App\Models\Discipline;
use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\Match_;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer l'administrateur
        User::create([
            'name' => 'Admin UniGames',
            'email' => 'admin@unigames.gn',
            'password' => Hash::make('password'),
        ]);

        // Créer une édition
        $edition = Edition::create([
            'nom' => 'Jeux Universitaires 2026',
            'date_debut' => Carbon::parse('2026-03-01'),
            'date_fin' => Carbon::parse('2026-03-15'),
            'lieu' => 'Conakry, Guinée',
            'description' => 'Édition 2026 des jeux universitaires de Guinée regroupant les meilleures facultés du pays.',
            'statut' => 'en_cours',
        ]);

        // Créer les disciplines
        $football = Discipline::create([
            'nom' => 'Football',
            'nombre_joueurs_par_equipe' => 11,
            'description' => 'Football à 11 joueurs',
        ]);

        $basketball = Discipline::create([
            'nom' => 'Basketball',
            'nombre_joueurs_par_equipe' => 5,
            'description' => 'Basketball à 5 joueurs',
        ]);

        $volleyball = Discipline::create([
            'nom' => 'Volleyball',
            'nombre_joueurs_par_equipe' => 6,
            'description' => 'Volleyball à 6 joueurs',
        ]);

        $handball = Discipline::create([
            'nom' => 'Handball',
            'nombre_joueurs_par_equipe' => 7,
            'description' => 'Handball à 7 joueurs',
        ]);

        $athletisme = Discipline::create([
            'nom' => 'Athlétisme',
            'nombre_joueurs_par_equipe' => 4,
            'description' => 'Relais 4x100m et courses individuelles',
        ]);

        // Créer les facultés
        $facultes = [];
        $nomsUniversites = [
            ['nom' => 'Faculté des Sciences', 'universite' => 'Université Gamal Abdel Nasser de Conakry'],
            ['nom' => 'Faculté de Médecine', 'universite' => 'Université Gamal Abdel Nasser de Conakry'],
            ['nom' => 'Faculté de Droit', 'universite' => 'Université Général Lansana Conté de Sonfonia'],
            ['nom' => 'Faculté des Lettres', 'universite' => 'Université Général Lansana Conté de Sonfonia'],
            ['nom' => 'ISAV Faranah', 'universite' => 'Université Julius Nyerere de Kankan'],
            ['nom' => 'Faculté SMGA', 'universite' => 'Université Julius Nyerere de Kankan'],
        ];

        foreach ($nomsUniversites as $data) {
            $facultes[] = Faculte::create([
                'nom' => $data['nom'],
                'universite' => $data['universite'],
                'edition_id' => $edition->id,
            ]);
        }

        // Créer les équipes de football
        $equipesFootball = [];
        $prenoms = ['Mamadou', 'Ibrahima', 'Alpha', 'Ousmane', 'Mohamed', 'Abdoulaye', 'Boubacar', 'Thierno', 'Souleymane', 'Amadou', 'Sékou'];
        $noms = ['Diallo', 'Bah', 'Barry', 'Camara', 'Soumah', 'Condé', 'Sylla', 'Keita', 'Touré', 'Bangoura', 'Traoré'];
        $postes = ['Gardien', 'Défenseur', 'Défenseur', 'Défenseur', 'Défenseur', 'Milieu', 'Milieu', 'Milieu', 'Attaquant', 'Attaquant', 'Attaquant'];

        foreach (array_slice($facultes, 0, 4) as $index => $faculte) {
            $equipe = Equipe::create([
                'nom' => $faculte->nom . ' FC',
                'faculte_id' => $faculte->id,
                'discipline_id' => $football->id,
                'edition_id' => $edition->id,
            ]);
            $equipesFootball[] = $equipe;

            // Ajouter 11 joueurs par équipe
            for ($i = 0; $i < 11; $i++) {
                Joueur::create([
                    'nom' => $noms[($i + $index) % count($noms)],
                    'prenom' => $prenoms[($i + $index * 3) % count($prenoms)],
                    'numero_maillot' => $i + 1,
                    'poste' => $postes[$i],
                    'buts' => $i >= 8 ? rand(0, 5) : rand(0, 1), // Attaquants marquent plus
                    'equipe_id' => $equipe->id,
                ]);
            }
        }

        // Créer les équipes de basketball
        $equipesBasketball = [];
        foreach (array_slice($facultes, 0, 4) as $index => $faculte) {
            $equipe = Equipe::create([
                'nom' => $faculte->nom . ' Basket',
                'faculte_id' => $faculte->id,
                'discipline_id' => $basketball->id,
                'edition_id' => $edition->id,
            ]);
            $equipesBasketball[] = $equipe;

            for ($i = 0; $i < 5; $i++) {
                Joueur::create([
                    'nom' => $noms[($i + $index + 5) % count($noms)],
                    'prenom' => $prenoms[($i + $index * 2 + 1) % count($prenoms)],
                    'numero_maillot' => $i + 1,
                    'poste' => ['Meneur', 'Arrière', 'Ailier', 'Ailier fort', 'Pivot'][$i],
                    'buts' => 0,
                    'equipe_id' => $equipe->id,
                ]);
            }
        }

        // Créer des matchs de football
        $dates = [
            Carbon::parse('2026-03-01 15:00'),
            Carbon::parse('2026-03-03 16:00'),
            Carbon::parse('2026-03-05 15:00'),
            Carbon::parse('2026-03-07 16:00'),
            Carbon::parse('2026-03-10 15:00'),
            Carbon::parse('2026-03-12 16:00'),
        ];

        // Match 1 : Equipe 0 vs Equipe 1 (joué)
        Match_::create([
            'equipe_a_id' => $equipesFootball[0]->id,
            'equipe_b_id' => $equipesFootball[1]->id,
            'discipline_id' => $football->id,
            'edition_id' => $edition->id,
            'date_match' => $dates[0],
            'lieu' => 'Stade du 28 Septembre',
            'phase' => 'Poules',
            'score_a' => 2,
            'score_b' => 1,
            'statut' => 'joue',
        ]);

        // Match 2 : Equipe 2 vs Equipe 3 (joué)
        Match_::create([
            'equipe_a_id' => $equipesFootball[2]->id,
            'equipe_b_id' => $equipesFootball[3]->id,
            'discipline_id' => $football->id,
            'edition_id' => $edition->id,
            'date_match' => $dates[1],
            'lieu' => 'Stade du 28 Septembre',
            'phase' => 'Poules',
            'score_a' => 0,
            'score_b' => 0,
            'statut' => 'joue',
        ]);

        // Match 3 : Equipe 0 vs Equipe 2 (joué)
        Match_::create([
            'equipe_a_id' => $equipesFootball[0]->id,
            'equipe_b_id' => $equipesFootball[2]->id,
            'discipline_id' => $football->id,
            'edition_id' => $edition->id,
            'date_match' => $dates[2],
            'lieu' => 'Stade du 28 Septembre',
            'phase' => 'Poules',
            'score_a' => 3,
            'score_b' => 1,
            'statut' => 'joue',
        ]);

        // Match 4 : Equipe 1 vs Equipe 3 (planifié)
        Match_::create([
            'equipe_a_id' => $equipesFootball[1]->id,
            'equipe_b_id' => $equipesFootball[3]->id,
            'discipline_id' => $football->id,
            'edition_id' => $edition->id,
            'date_match' => $dates[3],
            'lieu' => 'Stade du 28 Septembre',
            'phase' => 'Poules',
            'statut' => 'planifie',
        ]);

        // Match 5 : Demi-finale (planifié)
        Match_::create([
            'equipe_a_id' => $equipesFootball[0]->id,
            'equipe_b_id' => $equipesFootball[3]->id,
            'discipline_id' => $football->id,
            'edition_id' => $edition->id,
            'date_match' => $dates[4],
            'lieu' => 'Stade du 28 Septembre',
            'phase' => 'Demi-finale',
            'statut' => 'planifie',
        ]);

        // Matchs de basketball
        Match_::create([
            'equipe_a_id' => $equipesBasketball[0]->id,
            'equipe_b_id' => $equipesBasketball[1]->id,
            'discipline_id' => $basketball->id,
            'edition_id' => $edition->id,
            'date_match' => Carbon::parse('2026-03-02 14:00'),
            'lieu' => 'Gymnase Universitaire',
            'phase' => 'Poules',
            'score_a' => 78,
            'score_b' => 65,
            'statut' => 'joue',
        ]);

        Match_::create([
            'equipe_a_id' => $equipesBasketball[2]->id,
            'equipe_b_id' => $equipesBasketball[3]->id,
            'discipline_id' => $basketball->id,
            'edition_id' => $edition->id,
            'date_match' => Carbon::parse('2026-03-09 14:00'),
            'lieu' => 'Gymnase Universitaire',
            'phase' => 'Poules',
            'statut' => 'planifie',
        ]);
    }
}
