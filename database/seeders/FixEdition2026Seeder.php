<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixEdition2026Seeder extends Seeder
{
    public function run()
    {
        // 1. Mettre l'édition 2026 en "terminee"
        DB::table('editions')
            ->where('nom', 'like', '%2026%')
            ->update(['statut' => 'terminee']);

        echo "Edition 2026 -> terminee\n";

        // 2. Transformer TOUS les matchs non joués en matchs joués avec scores détaillés
        $matchsPlanifies = DB::table('matchs')
            ->where('statut', '!=', 'joue')
            ->get();

        foreach ($matchsPlanifies as $match) {
            $scoreA = rand(0, 5);
            $scoreB = rand(0, 4);

            DB::table('matchs')->where('id', $match->id)->update([
                'statut' => 'joue',
                'score_a' => $scoreA,
                'score_b' => $scoreB,
                'buteurs' => json_encode(['equipe_a' => [], 'equipe_b' => []]),
            ]);
        }

        echo "Matchs planifies convertis en joues: " . count($matchsPlanifies) . "\n";

        // 3. Aussi mettre à jour les matchs existants "joue" qui n'ont pas de scores détaillés
        // pour que ce soit plus réaliste
        $matchsJoues = DB::table('matchs')->where('statut', 'joue')->get();
        echo "Total matchs joues: " . count($matchsJoues) . "\n";
    }
}
