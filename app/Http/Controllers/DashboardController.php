<?php

namespace App\Http\Controllers;

use App\Models\Incidente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $data = [
            'incidentesSinAtender' => $this->getIncidentesSinAtender($user),
            'estadisticas' => $this->getEstadisticas($user),
            'incidentesRecientes' => $this->getIncidentesRecientes($user),
            'notificaciones' => $this->getNotificaciones($user),
        ];

        return view('dashboard', $data);
    }

    private function getIncidentesSinAtender($user): int
    {
        if ($user->hasAnyRole(['superadmin', 'admin_infraestructura'])) {
            return Incidente::pendientes()->count();
        }

        if ($user->hasRole('operativo_servicio')) {
            return Incidente::asignadosA($user->id)
                ->whereIn('estado', ['asignado', 'en_proceso'])
                ->count();
        }

        if ($user->hasRole('director_programa')) {
            return Incidente::pendientes()
                ->where('solicitante_id', $user->id)
                ->orWhereHas('solicitante', function ($query) use ($user) {
                    $query->where('area', $user->area);
                })
                ->count();
        }

        if ($user->hasRole('docente_solicitante')) {
            return Incidente::solicitadosPor($user->id)
                ->whereNotIn('estado', ['resuelto', 'cerrado'])
                ->count();
        }

        return 0;
    }

    private function getEstadisticas($user): array
    {
        $query = $this->getBaseQuery($user);

        return [
            'total' => (clone $query)->count(),
            'pendientes' => (clone $query)->where('estado', 'pendiente')->count(),
            'en_proceso' => (clone $query)->whereIn('estado', ['asignado', 'en_proceso'])->count(),
            'resueltos' => (clone $query)->where('estado', 'resuelto')->count(),
            'cerrados' => (clone $query)->where('estado', 'cerrado')->count(),
            'por_prioridad' => [
                'urgente' => (clone $query)->where('prioridad', 'urgente')->count(),
                'alta' => (clone $query)->where('prioridad', 'alta')->count(),
                'media' => (clone $query)->where('prioridad', 'media')->count(),
                'baja' => (clone $query)->where('prioridad', 'baja')->count(),
            ],
        ];
    }

    private function getIncidentesRecientes($user)
    {
        return $this->getBaseQuery($user)
            ->with(['solicitante', 'asignado', 'categoria', 'salon.bloque'])
            ->latest()
            ->limit(10)
            ->get();
    }

    private function getNotificaciones($user): array
    {
        $notificaciones = [];

        if ($user->hasAnyRole(['superadmin', 'admin_infraestructura'])) {
            $sinAsignar = Incidente::pendientes()->whereNull('asignado_a')->count();
            if ($sinAsignar > 0) {
                $notificaciones[] = [
                    'tipo' => 'warning',
                    'mensaje' => "{$sinAsignar} incidente(s) sin asignar",
                    'icono' => 'alert-circle',
                ];
            }

            $urgentes = Incidente::where('prioridad', 'urgente')
                ->whereNotIn('estado', ['resuelto', 'cerrado'])
                ->count();
            if ($urgentes > 0) {
                $notificaciones[] = [
                    'tipo' => 'error',
                    'mensaje' => "{$urgentes} incidente(s) urgentes",
                    'icono' => 'alert-triangle',
                ];
            }
        }

        if ($user->hasRole('operativo_servicio')) {
            $porIniciar = Incidente::asignadosA($user->id)
                ->where('estado', 'asignado')
                ->count();
            if ($porIniciar > 0) {
                $notificaciones[] = [
                    'tipo' => 'info',
                    'mensaje' => "{$porIniciar} incidente(s) por iniciar",
                    'icono' => 'clipboard',
                ];
            }
        }

        return $notificaciones;
    }

    private function getBaseQuery($user)
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

    public function getNotificacionesCount()
    {
        $user = Auth::user();
        $count = $this->getIncidentesSinAtender($user);

        return response()->json(['count' => $count]);
    }

    public function exportarPdf()
    {
        $user = Auth::user();

        // Verificar permisos
        if (!$user->hasAnyRole(['superadmin', 'admin_infraestructura', 'director_programa'])) {
            abort(403, 'No tienes permisos para exportar reportes.');
        }

        // Obtener todos los incidentes según rol usando el método existente
        $incidentes = $this->getBaseQuery($user)
            ->with(['solicitante', 'asignado', 'categoria', 'salon.bloque'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Estadísticas
        $estadisticas = [
            'total' => $incidentes->count(),
            'pendientes' => $incidentes->where('estado', 'pendiente')->count(),
            'en_proceso' => $incidentes->where('estado', 'en_proceso')->count(),
            'resueltos' => $incidentes->where('estado', 'resuelto')->count(),
            'cerrados' => $incidentes->where('estado', 'cerrado')->count(),
            'por_prioridad' => [
                'urgente' => $incidentes->where('prioridad', 'urgente')->count(),
                'alta' => $incidentes->where('prioridad', 'alta')->count(),
                'media' => $incidentes->where('prioridad', 'media')->count(),
                'baja' => $incidentes->where('prioridad', 'baja')->count(),
            ]
        ];

        // Generar PDF
        $pdf = Pdf::loadView('incidentes.pdf-reporte', compact('incidentes', 'estadisticas', 'user'))
            ->setPaper('letter', 'portrait')
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif'
            ]);

        $filename = 'reporte-incidentes-' . now()->format('Y-m-d-His') . '.pdf';

        return $pdf->download($filename);
    }
}
