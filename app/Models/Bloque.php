<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloque extends Model
{
    protected $table = 'bloques';

    protected $fillable = [
        'nombre',
        'codigo',
        'pisos',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'pisos' => 'integer',
    ];

    public function salones(): HasMany
    {
        return $this->hasMany(Salon::class);
    }
}
