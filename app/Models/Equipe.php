<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipe extends Model
{
    protected $table = 'equipes';
    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'faculte_id',
        'discipline_id',
        'edition_id',
    ];

    /**
     * La faculté de cette équipe.
     */
    public function faculte(): BelongsTo
    {
        return $this->belongsTo(Faculte::class);
    }

    /**
     * La discipline de cette équipe.
     */
    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    /**
     * L'édition de cette équipe.
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Les joueurs de cette équipe.
     */
    public function joueurs(): HasMany
    {
        return $this->hasMany(Joueur::class);
    }

    /**
     * Les matchs où cette équipe joue en tant qu'équipe A.
     */
    public function matchsAsEquipeA(): HasMany
    {
        return $this->hasMany(Match_::class, 'equipe_a_id');
    }

    /**
     * Les matchs où cette équipe joue en tant qu'équipe B.
     */
    public function matchsAsEquipeB(): HasMany
    {
        return $this->hasMany(Match_::class, 'equipe_b_id');
    }

    /**
     * Obtenir tous les matchs de l'équipe (A ou B).
     */
    public function tousLesMatchs()
    {
        return Match_::where('equipe_a_id', $this->id)
            ->orWhere('equipe_b_id', $this->id);
    }

    /**
     * Calculer les points de l'équipe (victoire=3, nul=1, défaite=0).
     */
    public function getPointsAttribute(): int
    {
        $points = 0;
        $matchsJoues = $this->tousLesMatchs()->where('statut', 'joue')->get();

        foreach ($matchsJoues as $match) {
            if ($match->equipe_a_id === $this->id) {
                if ($match->score_a > $match->score_b) $points += 3;
                elseif ($match->score_a === $match->score_b) $points += 1;
            } else {
                if ($match->score_b > $match->score_a) $points += 3;
                elseif ($match->score_a === $match->score_b) $points += 1;
            }
        }

        return $points;
    }

    /**
     * Nombre de matchs joués.
     */
    public function getMatchsJouesAttribute(): int
    {
        return $this->tousLesMatchs()->where('statut', 'joue')->count();
    }

    /**
     * Nombre de victoires.
     */
    public function getVictoiresAttribute(): int
    {
        $v = 0;
        $matchs = $this->tousLesMatchs()->where('statut', 'joue')->get();
        foreach ($matchs as $match) {
            if ($match->equipe_a_id === $this->id && $match->score_a > $match->score_b) $v++;
            if ($match->equipe_b_id === $this->id && $match->score_b > $match->score_a) $v++;
        }
        return $v;
    }

    /**
     * Nombre de nuls.
     */
    public function getNulsAttribute(): int
    {
        return $this->tousLesMatchs()->where('statut', 'joue')
            ->whereColumn('score_a', 'score_b')->count();
    }

    /**
     * Nombre de défaites.
     */
    public function getDefaitesAttribute(): int
    {
        $d = 0;
        $matchs = $this->tousLesMatchs()->where('statut', 'joue')->get();
        foreach ($matchs as $match) {
            if ($match->equipe_a_id === $this->id && $match->score_a < $match->score_b) $d++;
            if ($match->equipe_b_id === $this->id && $match->score_b < $match->score_a) $d++;
        }
        return $d;
    }

    /**
     * Buts marqués.
     */
    public function getButsMarquesAttribute(): int
    {
        $buts = 0;
        $matchs = $this->tousLesMatchs()->where('statut', 'joue')->get();
        foreach ($matchs as $match) {
            if ($match->equipe_a_id === $this->id) $buts += $match->score_a;
            else $buts += $match->score_b;
        }
        return $buts;
    }

    /**
     * Buts encaissés.
     */
    public function getButsEncaissesAttribute(): int
    {
        $buts = 0;
        $matchs = $this->tousLesMatchs()->where('statut', 'joue')->get();
        foreach ($matchs as $match) {
            if ($match->equipe_a_id === $this->id) $buts += $match->score_b;
            else $buts += $match->score_a;
        }
        return $buts;
    }

    /**
     * Différence de buts.
     */
    public function getDifferenceButs(): int
    {
        return $this->buts_marques - $this->buts_encaisses;
    }
}
