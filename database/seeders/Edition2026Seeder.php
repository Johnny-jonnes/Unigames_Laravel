<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Edition2026Seeder extends Seeder
{
    public function run()
    {
        // 1. Création de l'édition 2026
        $editionId = DB::table('editions')->insertGetId([
            'nom' => 'Jeux Universitaires 2026',
            'date_debut' => '2026-05-01',
            'date_fin' => '2026-05-20',
            'lieu' => 'Complexe Sportif Olembe',
            'statut' => 'en_cours',
            'description' => 'La plus grande compétition universitaire avec une participation record.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Création de 8 Facultés
        $facultes = [];
        $facNoms = [
            'Faculté des Sciences (FAS)',
            'Faculté de Médecine (FMSB)',
            'École Nationale Supérieure Polytechnique (ENSP)',
            'Faculté des Arts et Lettres (FAL)',
            'Faculté des Sciences Économiques (FSEG)',
            'Faculté de Droit (FSJP)',
            'Institut National de la Jeunesse et des Sports (INJS)',
            'École Normale Supérieure (ENS)'
        ];

        foreach ($facNoms as $nom) {
            $facultes[] = DB::table('facultes')->insertGetId([
                'nom' => $nom,
                'universite' => 'Université Fédérale',
                'edition_id' => $editionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 3. Récupération des disciplines existantes (Football, Basketball, Volleyball)
        $disciplines = DB::table('disciplines')->pluck('id')->toArray();
        if (empty($disciplines)) {
            $disciplines[] = DB::table('disciplines')->insertGetId(['nom' => 'Football', 'nombre_joueurs_par_equipe' => 11]);
            $disciplines[] = DB::table('disciplines')->insertGetId(['nom' => 'Basketball', 'nombre_joueurs_par_equipe' => 5]);
        }

        // 4. Création des Équipes et Joueurs
        $equipesMap = []; // discipline_id => array of equipe_ids
        foreach ($disciplines as $discId) {
            $equipesMap[$discId] = [];
            // Créer une équipe par faculté pour chaque discipline
            foreach ($facultes as $facId) {
                $equipeId = DB::table('equipes')->insertGetId([
                    'nom' => 'Équipe ' . DB::table('facultes')->where('id', $facId)->value('nom') . ' - D' . $discId,
                    'faculte_id' => $facId,
                    'discipline_id' => $discId,
                    'edition_id' => $editionId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $equipesMap[$discId][] = $equipeId;

                // Création de 5 à 15 joueurs par équipe
                $nbJoueurs = rand(5, 15);
                for ($j = 1; $j <= $nbJoueurs; $j++) {
                    DB::table('joueurs')->insert([
                        'nom' => 'Joueur' . $j . '_' . $equipeId,
                        'prenom' => 'Prenom' . rand(1, 99),
                        'numero_maillot' => $j,
                        'equipe_id' => $equipeId,
                        'buts' => rand(0, 5),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        // 5. Création massive de Matchs
        // On génère des matchs de poules (joués) et des phases finales (planifiés)
        foreach ($disciplines as $discId) {
            $eqs = $equipesMap[$discId];
            $countEqs = count($eqs);

            // Matchs joués (aléatoires)
            for ($i = 0; $i < 15; $i++) {
                $eqA = $eqs[array_rand($eqs)];
                $eqB = $eqs[array_rand($eqs)];
                if ($eqA === $eqB) continue;

                $scoreA = rand(0, 4);
                $scoreB = rand(0, 4);

                DB::table('matchs')->insert([
                    'equipe_a_id' => $eqA,
                    'equipe_b_id' => $eqB,
                    'discipline_id' => $discId,
                    'edition_id' => $editionId,
                    'date_match' => Carbon::now()->subDays(rand(1, 10))->format('Y-m-d H:i:s'),
                    'lieu' => 'Terrain ' . rand(1, 5),
                    'phase' => 'Poules',
                    'score_a' => $scoreA,
                    'score_b' => $scoreB,
                    'statut' => 'joue',
                    'buteurs' => json_encode(['equipe_a' => [], 'equipe_b' => []]),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Matchs planifiés (Quarts, Demis, Finale)
            DB::table('matchs')->insert([
                'equipe_a_id' => $eqs[0],
                'equipe_b_id' => $eqs[1],
                'discipline_id' => $discId,
                'edition_id' => $editionId,
                'date_match' => Carbon::now()->addDays(2)->format('Y-m-d H:i:s'),
                'lieu' => 'Stade Principal',
                'phase' => 'Demi',
                'statut' => 'planifie',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('matchs')->insert([
                'equipe_a_id' => $eqs[2],
                'equipe_b_id' => $eqs[3],
                'discipline_id' => $discId,
                'edition_id' => $editionId,
                'date_match' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
                'lieu' => 'Stade Principal',
                'phase' => 'Finale',
                'statut' => 'planifie',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
