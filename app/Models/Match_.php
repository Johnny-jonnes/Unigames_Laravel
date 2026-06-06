<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Nommé Match_ car "match" est un mot réservé en PHP.
 */
class Match_ extends Model
{
    /**
     * La table associée au modèle.
     */
    protected $table = 'matchs';

    /**
     * Les attributs assignables en masse.
     */
    protected $fillable = [
        'equipe_a_id',
        'equipe_b_id',
        'discipline_id',
        'edition_id',
        'date_match',
        'lieu',
        'phase',
        'score_a',
        'score_b',
        'statut',
        'buteurs',
    ];

    /**
     * Les attributs qui doivent être castés.
     */
    protected function casts(): array
    {
        return [
            'date_match' => 'datetime',
            'score_a' => 'integer',
            'score_b' => 'integer',
            'buteurs' => 'array',
        ];
    }

    /**
     * L'équipe A (domicile).
     */
    public function equipeA(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_a_id');
    }

    /**
     * L'équipe B (visiteur).
     */
    public function equipeB(): BelongsTo
    {
        return $this->belongsTo(Equipe::class, 'equipe_b_id');
    }

    /**
     * La discipline du match.
     */
    public function discipline(): BelongsTo
    {
        return $this->belongsTo(Discipline::class);
    }

    /**
     * L'édition du match.
     */
    public function edition(): BelongsTo
    {
        return $this->belongsTo(Edition::class);
    }

    /**
     * Déterminer le vainqueur du match.
     */
    public function getVainqueurAttribute(): ?Equipe
    {
        if ($this->statut !== 'joue') return null;
        if ($this->score_a > $this->score_b) return $this->equipeA;
        if ($this->score_b > $this->score_a) return $this->equipeB;
        return null; // Match nul
    }

    /**
     * Vérifier si le match est un nul.
     */
    public function getEstNulAttribute(): bool
    {
        return $this->statut === 'joue' && $this->score_a === $this->score_b;
    }
}
