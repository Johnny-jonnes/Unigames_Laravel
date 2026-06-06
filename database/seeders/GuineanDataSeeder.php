<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuineanDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Universités et Facultés Guinéennes réelles
        $universites = [
            ['nom' => 'UGANC (Gamal Abdel Nasser)', 'universite' => 'Conakry'],
            ['nom' => 'UGLCS (Sonfonia)', 'universite' => 'Conakry'],
            ['nom' => 'Université Julius Nyerere', 'universite' => 'Kankan'],
            ['nom' => 'Université de Kindia', 'universite' => 'Kindia'],
            ['nom' => 'Université de Labé', 'universite' => 'Labé'],
            ['nom' => 'IST (Institut Sup. de Tech)', 'universite' => 'Mamou'],
            ['nom' => 'ISMGB (Mines et Géologie)', 'universite' => 'Boké'],
            ['nom' => 'Université Nongo', 'universite' => 'Conakry'],
            ['nom' => 'ISAV (Agro-Vétérinaire)', 'universite' => 'Faranah'],
            ['nom' => 'ISIC (Info & Com)', 'universite' => 'Kountia']
        ];

        // Mettre à jour les facultés existantes (jusqu'à 10)
        $facultesIds = DB::table('facultes')->orderBy('id')->pluck('id')->toArray();
        foreach ($facultesIds as $index => $id) {
            if (isset($universites[$index])) {
                DB::table('facultes')->where('id', $id)->update([
                    'nom' => $universites[$index]['nom'],
                    'universite' => $universites[$index]['universite'],
                ]);
            }
        }

        // 2. Mettre à jour le nom des équipes en fonction des nouvelles facultés
        $equipes = DB::table('equipes')->get();
        foreach ($equipes as $equipe) {
            $facNom = DB::table('facultes')->where('id', $equipe->faculte_id)->value('nom');
            $discId = $equipe->discipline_id;
            
            // Ex: "Équipe UGANC - Football"
            $nouveauNom = 'Équipe ' . explode(' ', $facNom)[0] . ' - D' . $discId;
            DB::table('equipes')->where('id', $equipe->id)->update(['nom' => $nouveauNom]);
        }

        // 3. Noms Guinéens pour les joueurs
        $prenomsGarcons = ['Mamadou', 'Alpha', 'Oumar', 'Ibrahima', 'Amadou', 'Sekou', 'Fode', 'Lansana', 'Aboubacar', 'Ousmane', 'Moussa', 'Souleymane', 'Karim', 'Alhassane', 'Alseny', 'Cheick', 'Salifou'];
        $prenomsFilles = ['Fatoumata', 'Mariam', 'Aissatou', 'Aminata', 'Kadiatou', 'Binta', 'Oumou', 'Hawa', 'Djenabou', 'Mabinty', 'Salmatou', 'Rouguiatou'];
        $nomsDeFamille = ['Diallo', 'Barry', 'Bah', 'Camara', 'Sylla', 'Keita', 'Conde', 'Traore', 'Toure', 'Soumah', 'Bangoura', 'Kourouma', 'Cisse', 'Sow', 'Diabate', 'Fofana', 'Kante', 'Mara'];

        $joueursIds = DB::table('joueurs')->pluck('id')->toArray();
        foreach ($joueursIds as $id) {
            $sexe = (rand(1, 100) > 20) ? 'M' : 'F'; // 80% hommes pour le sport universitaire, juste pour la stat
            $prenom = ($sexe === 'M') ? $prenomsGarcons[array_rand($prenomsGarcons)] : $prenomsFilles[array_rand($prenomsFilles)];
            $nom = $nomsDeFamille[array_rand($nomsDeFamille)];

            DB::table('joueurs')->where('id', $id)->update([
                'nom' => strtoupper($nom),
                'prenom' => $prenom,
                'sexe' => $sexe
            ]);
        }

        echo "Mise a jour terminee : Facultes et Joueurs ont des noms guineens.\n";
    }
}
