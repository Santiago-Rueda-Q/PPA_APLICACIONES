<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salon extends Model
{
    protected $table = 'salones';

    protected $fillable = [
        'bloque_id',
        'codigo',
        'piso',
        'capacidad',
        'tipo',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'piso' => 'integer',
        'capacidad' => 'integer',
    ];

    public function bloque(): BelongsTo
    {
        return $this->belongsTo(Bloque::class);
    }

    public function incidentes(): HasMany
    {
        return $this->hasMany(Incidente::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->bloque->nombre} - {$this->codigo}";
    }
}
