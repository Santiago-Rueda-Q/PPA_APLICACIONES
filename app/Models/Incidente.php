<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Incidente extends Model
{
    use SoftDeletes;

    protected $table = 'incidentes';

    protected $fillable = [
        'codigo',
        'solicitante_id',
        'categoria_id',
        'salon_id',
        'asignado_a',
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'fecha_asignacion',
        'fecha_inicio_atencion',
        'fecha_resolucion',
        'fecha_cierre',
        'solucion',
        'observaciones',
        'evidencias',
    ];

    protected $casts = [
        'evidencias' => 'array',
        'fecha_asignacion' => 'datetime',
        'fecha_inicio_atencion' => 'datetime',
        'fecha_resolucion' => 'datetime',
        'fecha_cierre' => 'datetime',
    ];

    // Relaciones
    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }

    public function asignado(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaIncidente::class, 'categoria_id');
    }

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    public function comentarios(): HasMany
    {
        return $this->hasMany(ComentarioIncidente::class);
    }

    public function historialEstados(): HasMany
    {
        return $this->hasMany(HistorialEstado::class);
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAsignadosA($query, int $userId)
    {
        return $query->where('asignado_a', $userId);
    }

    public function scopeSolicitadosPor($query, int $userId)
    {
        return $query->where('solicitante_id', $userId);
    }

    public function scopePrioridad($query, string $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    // Métodos auxiliares
    public function esPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }

    public function estaResuelto(): bool
    {
        return in_array($this->estado, ['resuelto', 'cerrado']);
    }

    public function puedeSerEditadoPor(User $user): bool
    {
        return $user->hasRole('superadmin') ||
               $user->hasRole('admin_infraestructura') ||
               ($this->solicitante_id === $user->id && $this->estado === 'pendiente');
    }

    public function puedeSerAsignado(): bool
    {
        return in_array($this->estado, ['pendiente', 'asignado']);
    }

    // Badges de color según estado
    public function getEstadoBadgeColorAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'asignado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'en_proceso' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'resuelto' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'cerrado' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
            'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPrioridadBadgeColorAttribute(): string
    {
        return match($this->prioridad) {
            'urgente' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'alta' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'media' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'baja' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Generar código automático
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($incidente) {
            if (empty($incidente->codigo)) {
                $incidente->codigo = self::generarCodigo();
            }
        });
    }

    public static function generarCodigo(): string
    {
        $year = date('Y');
        $ultimo = self::whereYear('created_at', $year)->latest('id')->first();
        $numero = $ultimo ? intval(substr($ultimo->codigo, -4)) + 1 : 1;

        return sprintf('INC-%s-%04d', $year, $numero);
    }

    public function comentar(Request $request, Incidente $incidente)
    {
        $this->authorize('addComment', $incidente);

        $validated = $request->validate([
            'comentario' => 'required|string',
            'es_interno' => 'nullable|boolean',
        ]);

        $validated['incidente_id'] = $incidente->id;
        $validated['user_id'] = Auth::id();
        $validated['es_interno'] = $validated['es_interno'] ?? false;

        ComentarioIncidente::create($validated);

        return redirect()
            ->back()
            ->with('success', 'Comentario agregado exitosamente');
    }
}
