<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaIncidente extends Model
{
    protected $table = 'categorias_incidentes';

    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'color',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function incidentes(): HasMany
    {
        return $this->hasMany(Incidente::class, 'categoria_id');
    }
}
