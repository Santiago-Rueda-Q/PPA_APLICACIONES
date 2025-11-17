<?php

namespace App\Http\Controllers;

use App\Models\Incidente;
use App\Models\CategoriaIncidente;
use App\Models\Salon;
use App\Models\User;
use App\Models\HistorialEstado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\ComentarioIncidente;

class IncidenteController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $incidentes = $this->getIncidentesSegunRol($user)
            ->with(['solicitante', 'asignado', 'categoria', 'salon.bloque'])
            ->latest()
            ->paginate(15);

        $categorias = CategoriaIncidente::where('activo', true)->get();
        $salones = Salon::with('bloque')->where('activo', true)->get();
        $operativos = User::role('operativo_servicio')->where('is_active', true)->get();

        return view('incidentes.index', compact('incidentes', 'categorias', 'salones', 'operativos'));
    }

    public function create()
    {
        $this->authorize('create', Incidente::class);

        $categorias = CategoriaIncidente::where('activo', true)->get();
        $salones = Salon::with('bloque')->where('activo', true)->get();

        return view('incidentes.create', compact('categorias', 'salones'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Incidente::class);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias_incidentes,id',
            'salon_id' => 'nullable|exists:salones,id',
            'prioridad' => 'required|in:baja,media,alta,urgente',
        ]);

        $validated['solicitante_id'] = Auth::id();
        $validated['estado'] = 'pendiente';

        $incidente = Incidente::create($validated);

        return redirect()
            ->route('incidentes.show', $incidente)
            ->with('success', 'Incidente creado exitosamente. Código: ' . $incidente->codigo);
    }

    public function show(Incidente $incidente)
    {
        $this->authorize('view', $incidente);

        $incidente->load([
            'solicitante',
            'asignado',
            'categoria',
            'salon.bloque',
            'comentarios.usuario',
            'historialEstados.usuario'
        ]);

        $operativos = User::role('operativo_servicio')->where('is_active', true)->get();

        return view('incidentes.show', compact('incidente', 'operativos'));
    }

    public function edit(Incidente $incidente)
    {
        $this->authorize('update', $incidente);

        $categorias = CategoriaIncidente::where('activo', true)->get();
        $salones = Salon::with('bloque')->where('activo', true)->get();

        return view('incidentes.edit', compact('incidente', 'categorias', 'salones'));
    }

    public function update(Request $request, Incidente $incidente)
    {
        $this->authorize('update', $incidente);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria_id' => 'required|exists:categorias_incidentes,id',
            'salon_id' => 'nullable|exists:salones,id',
            'prioridad' => 'required|in:baja,media,alta,urgente',
        ]);

        $incidente->update($validated);

        return redirect()
            ->route('incidentes.show', $incidente)
            ->with('success', 'Incidente actualizado exitosamente');
    }

    public function asignar(Request $request, Incidente $incidente)
    {
        $this->authorize('assign', $incidente);

        $validated = $request->validate([
            'asignado_a' => 'required|exists:users,id',
            'observacion' => 'nullable|string',
        ]);

        DB::transaction(function () use ($incidente, $validated) {
            $estadoAnterior = $incidente->estado;

            $incidente->update([
                'asignado_a' => $validated['asignado_a'],
                'estado' => 'asignado',
                'fecha_asignacion' => now(),
            ]);

            HistorialEstado::create([
                'incidente_id' => $incidente->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'asignado',
                'observacion' => $validated['observacion'] ?? 'Incidente asignado',
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Incidente asignado exitosamente');
    }

    public function cambiarEstado(Request $request, Incidente $incidente)
    {
        $this->authorize('changeStatus', $incidente);

        $validated = $request->validate([
            'estado' => 'required|in:pendiente,asignado,en_proceso,resuelto,cerrado,cancelado',
            'observacion' => 'nullable|string',
            'solucion' => 'nullable|string',
        ]);

        DB::transaction(function () use ($incidente, $validated) {
            $estadoAnterior = $incidente->estado;
            $estadoNuevo = $validated['estado'];

            $updateData = ['estado' => $estadoNuevo];

            if ($estadoNuevo === 'en_proceso' && !$incidente->fecha_inicio_atencion) {
                $updateData['fecha_inicio_atencion'] = now();
            }

            if ($estadoNuevo === 'resuelto') {
                $updateData['fecha_resolucion'] = now();
                $updateData['solucion'] = $validated['solucion'] ?? null;
            }

            if ($estadoNuevo === 'cerrado') {
                $updateData['fecha_cierre'] = now();
            }

            $incidente->update($updateData);

            HistorialEstado::create([
                'incidente_id' => $incidente->id,
                'user_id' => Auth::id(),
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => $estadoNuevo,
                'observacion' => $validated['observacion'] ?? null,
            ]);
        });

        return redirect()
            ->back()
            ->with('success', 'Estado del incidente actualizado');
    }

    public function destroy(Incidente $incidente)
    {
        $this->authorize('delete', $incidente);

        $incidente->delete();

        return redirect()
            ->route('incidentes.index')
            ->with('success', 'Incidente eliminado exitosamente');
    }

    private function getIncidentesSegunRol($user)
    {
        $query = Incidente::query();

        if ($user->hasAnyRole(['superadmin', 'admin_infraestructura'])) {
            return $query;
        }

        if ($user->hasRole('operativo_servicio')) {
            return $query->asignadosA($user->id);
        }

        if ($user->hasRole('director_programa')) {
            return $query->where(function ($q) use ($user) {
                $q->where('solicitante_id', $user->id)
                    ->orWhereHas('solicitante', function ($subQ) use ($user) {
                        $subQ->where('area', $user->area);
                    });
            });
        }

        if ($user->hasRole('docente_solicitante')) {
            return $query->solicitadosPor($user->id);
        }

        return $query->whereRaw('1 = 0');
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
