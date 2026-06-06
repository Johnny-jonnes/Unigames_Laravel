<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Edition extends Model
{
    /**
     * La table associée au modèle (Laravel déduit 'editions' par défaut, mais on peut le forcer au cas où)
     */
    protected $table = 'editions';
    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'date_debut',
        'date_fin',
        'lieu',
        'description',
        'statut',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    /**
     * Les facultés inscrites à cette édition.
     */
    public function facultes(): HasMany
    {
        return $this->hasMany(Faculte::class);
    }

    /**
     * Les équipes participant à cette édition.
     */
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }

    /**
     * Les matchs de cette édition.
     */
    public function matchs(): HasMany
    {
        return $this->hasMany(Match_::class, 'edition_id');
    }
}
