<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComentarioIncidente extends Model
{
    protected $table = 'comentarios_incidentes';

    protected $fillable = [
        'incidente_id',
        'user_id',
        'comentario',
        'es_interno',
        'adjuntos',
    ];

    protected $casts = [
        'es_interno' => 'boolean',
        'adjuntos' => 'array',
    ];

    public function incidente(): BelongsTo
    {
        return $this->belongsTo(Incidente::class);
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
