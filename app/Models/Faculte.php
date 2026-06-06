<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculte extends Model
{
    protected $table = 'facultes';

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'nom',
        'universite',
        'logo',
        'edition_id',
    ];

    /**
     * L'édition à laquelle appartient cette faculté.
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Les équipes de cette faculté.
     */
    public function equipes(): HasMany
    {
        return $this->hasMany(Equipe::class);
    }
}
