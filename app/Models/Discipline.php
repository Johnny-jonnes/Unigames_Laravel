<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Discipline extends Model
{
    protected $table = 'disciplines';
    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'nombre_joueurs_par_equipe',
        'icone',
        'description',
    ];

    /**
     * Les équipes de cette discipline.
     */
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }

    /**
     * Les matchs de cette discipline.
     */
    public function matchs(): HasMany
    {
        return $this->hasMany(Match_::class, 'discipline_id');
    }
}
