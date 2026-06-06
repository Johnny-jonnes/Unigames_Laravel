<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Joueur extends Model
{
    protected $table = 'joueurs';
    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'prenom',
        'sexe',
        'numero_maillot',
        'equipe_id',
    ];

    /**
     * L'équipe du joueur.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    /**
     * Nom complet du joueur.
     */
    public function getNomCompletAttribute(): string
    {
        return $this->prenom . ' ' . $this->nom;
    }
}
