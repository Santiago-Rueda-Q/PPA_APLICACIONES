<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('incidentes.index') }}"
                    class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-xl theme-text leading-tight">
                        Incidente {{ $incidente->codigo }}
                    </h2>
                    <p class="text-sm text-muted">Creado {{ $incidente->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @can('update', $incidente)
                    <a href="{{ route('incidentes.edit', $incidente) }}"
                        class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        Editar
                    </a>
                @endcan

                @can('delete', $incidente)
                    <form method="POST" action="{{ route('incidentes.destroy', $incidente) }}"
                        onsubmit="return confirm('¿Está seguro de eliminar este incidente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Eliminar
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Columna Principal -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Información del Incidente -->
                    <div class="theme-card rounded-lg shadow-sm p-6">
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-2xl font-bold theme-text">{{ $incidente->titulo }}</h3>
                            <span
                                class="px-3 py-1 text-sm font-semibold rounded-full {{ $incidente->estado_badge_color }}">
                                {{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}
                            </span>
                        </div>

                        <div class="prose max-w-none theme-text">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                {{ $incidente->descripcion }}</p>
                        </div>

                        @if ($incidente->solucion)
                            <div
                                class="mt-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <h4
                                    class="font-semibold text-green-900 dark:text-green-300 mb-2 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Solución Implementada
                                </h4>
                                <p class="text-green-800 dark:text-green-400 whitespace-pre-wrap">
                                    {{ $incidente->solucion }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Historial de Estados -->
                    @if ($incidente->historialEstados->count() > 0)
                        <div class="theme-card rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold theme-text mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Historial de Estados
                            </h3>
                            <div class="space-y-4">
                                @foreach ($incidente->historialEstados as $historial)
                                    <div class="flex items-start gap-4 pb-4 border-b theme-bd last:border-0">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="font-medium theme-text">{{ $historial->usuario->name }}</span>
                                                <span
                                                    class="text-xs text-muted">{{ $historial->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-sm text-muted">
                                                Cambió de
                                                <span
                                                    class="font-semibold">{{ ucfirst(str_replace('_', ' ', $historial->estado_anterior)) }}</span>
                                                a
                                                <span
                                                    class="font-semibold">{{ ucfirst(str_replace('_', ' ', $historial->estado_nuevo)) }}</span>
                                            </p>
                                            @if ($historial->observacion)
                                                <p class="text-sm theme-text mt-1">{{ $historial->observacion }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Comentarios -->
                    <div class="theme-card rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold theme-text mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                            Comentarios y Seguimiento
                        </h3>

                        <!-- Lista de Comentarios -->
                        <div class="space-y-4 mb-6">
                            @forelse($incidente->comentarios as $comentario)
                                <div class="flex gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-[var(--primary)] text-white flex items-center justify-center font-semibold">
                                            {{ substr($comentario->usuario->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span
                                                class="font-semibold theme-text">{{ $comentario->usuario->name }}</span>
                                            <span
                                                class="text-xs text-muted">{{ $comentario->created_at->diffForHumans() }}</span>
                                            @if ($comentario->es_interno)
                                                <span
                                                    class="text-xs px-2 py-0.5 bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-400 rounded">
                                                    Interno
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm theme-text whitespace-pre-wrap">{{ $comentario->comentario }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center text-muted py-8">No hay comentarios aún</p>
                            @endforelse
                        </div>

                        <!-- Formulario de Comentario -->
                        @can('addComment', $incidente)
                            <form method="POST" action="{{ route('incidentes.comentar', $incidente) }}"
                                class="border-t theme-bd pt-4">
                                @csrf
                                <textarea name="comentario" rows="3" placeholder="Agregar un comentario..." required
                                    class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                                 focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent"></textarea>
                                <div class="flex items-center justify-between mt-3">
                                    @if (auth()->user()->hasAnyRole(['superadmin', 'admin_infraestructura', 'operativo_servicio']))
                                        <label class="flex items-center gap-2">
                                            <input type="checkbox" name="es_interno" value="1" class="rounded">
                                            <span class="text-sm theme-text">Comentario interno (solo visible para el
                                                equipo)</span>
                                        </label>
                                    @else
                                        <div></div>
                                    @endif
                                    <button type="submit"
                                        class="px-4 py-2 bg-[var(--primary)] text-white rounded-lg hover:bg-[var(--accent)] transition-colors">
                                        Comentar
                                    </button>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>

                <!-- Columna Lateral -->
                <div class="space-y-6">

                    <!-- Detalles -->
                    <div class="theme-card rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold theme-text mb-4">Detalles</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-muted">Código</dt>
                                <dd class="text-sm font-mono font-semibold theme-text mt-1">{{ $incidente->codigo }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-muted">Categoría</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                        style="background-color: {{ $incidente->categoria->color }}22; color: {{ $incidente->categoria->color }}">
                                        {{ $incidente->categoria->nombre }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-muted">Prioridad</dt>
                                <dd class="mt-1">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->prioridad_badge_color }}">
                                        {{ ucfirst($incidente->prioridad) }}
                                    </span>
                                </dd>
                            </div>
                            @if ($incidente->salon)
                                <div>
                                    <dt class="text-sm font-medium text-muted">Salón</dt>
                                    <dd class="text-sm theme-text mt-1 font-semibold">
                                        {{ $incidente->salon->codigo }} - {{ $incidente->salon->bloque->nombre }}
                                    </dd>
                                    <dd class="text-xs text-muted">Piso {{ $incidente->salon->piso }} •
                                        {{ ucfirst($incidente->salon->tipo) }}</dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-muted">Solicitante</dt>
                                <dd class="text-sm theme-text mt-1">{{ $incidente->solicitante->name }}</dd>
                                <dd class="text-xs text-muted">{{ $incidente->solicitante->email }}</dd>
                            </div>
                            @if ($incidente->asignado)
                                <div>
                                    <dt class="text-sm font-medium text-muted">Asignado a</dt>
                                    <dd class="text-sm theme-text mt-1">{{ $incidente->asignado->name }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Fechas -->
                    <div class="theme-card rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold theme-text mb-4">Cronología</h3>
                        <dl class="space-y-3 text-sm">
                            <div>
                                <dt class="text-muted">Creado</dt>
                                <dd class="theme-text font-medium mt-1">
                                    {{ $incidente->created_at->format('d/m/Y H:i') }}</dd>
                            </div>
                            @if ($incidente->fecha_asignacion)
                                <div>
                                    <dt class="text-muted">Asignado</dt>
                                    <dd class="theme-text font-medium mt-1">
                                        {{ $incidente->fecha_asignacion->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                            @if ($incidente->fecha_inicio_atencion)
                                <div>
                                    <dt class="text-muted">Inicio Atención</dt>
                                    <dd class="theme-text font-medium mt-1">
                                        {{ $incidente->fecha_inicio_atencion->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                            @if ($incidente->fecha_resolucion)
                                <div>
                                    <dt class="text-muted">Resuelto</dt>
                                    <dd class="theme-text font-medium mt-1">
                                        {{ $incidente->fecha_resolucion->format('d/m/Y H:i') }}</dd>
                                </div>
                            @endif
                        </dl>
                    </div>

                    <!-- Acciones -->
                    @can('assign', $incidente)
                        <div class="theme-card rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold theme-text mb-4">Asignar Operativo</h3>
                            <form method="POST" action="{{ route('incidentes.asignar', $incidente) }}">
                                @csrf
                                <select name="asignado_a" required
                                    class="w-full rounded-lg border theme-bd px-4 py-2 theme-text mb-3">
                                    <option value="">Seleccionar operativo</option>
                                    @foreach ($operativos as $operativo)
                                        <option value="{{ $operativo->id }}"
                                            {{ $incidente->asignado_a == $operativo->id ? 'selected' : '' }}>
                                            {{ $operativo->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <textarea name="observacion" rows="2" placeholder="Observaciones (opcional)"
                                    class="w-full rounded-lg border theme-bd px-4 py-2 theme-text mb-3"></textarea>
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-[var(--primary)] text-white rounded-lg hover:bg-[var(--accent)] transition-colors">
                                    Asignar
                                </button>
                            </form>
                        </div>
                    @endcan

                    @can('changeStatus', $incidente)
                        <div class="theme-card rounded-lg shadow-sm p-6">
                            <h3 class="text-lg font-semibold theme-text mb-4">Cambiar Estado</h3>
                            <form method="POST" action="{{ route('incidentes.cambiar-estado', $incidente) }}">
                                @csrf
                                <select name="estado" required
                                    class="w-full rounded-lg border theme-bd px-4 py-2 theme-text mb-3">
                                    <option value="pendiente" {{ $incidente->estado == 'pendiente' ? 'selected' : '' }}>
                                        Pendiente</option>
                                    <option value="asignado" {{ $incidente->estado == 'asignado' ? 'selected' : '' }}>
                                        Asignado</option>
                                    <option value="en_proceso" {{ $incidente->estado == 'en_proceso' ? 'selected' : '' }}>
                                        En Proceso</option>
                                    <option value="resuelto" {{ $incidente->estado == 'resuelto' ? 'selected' : '' }}>
                                        Resuelto</option>
                                    <option value="cerrado" {{ $incidente->estado == 'cerrado' ? 'selected' : '' }}>
                                        Cerrado</option>
                                    <option value="cancelado" {{ $incidente->estado == 'cancelado' ? 'selected' : '' }}>
                                        Cancelado</option>
                                </select>
                                <textarea name="solucion" rows="3"
                                    placeholder="Descripción de la solución (requerido para marcar como resuelto)"
                                    class="w-full rounded-lg border theme-bd px-4 py-2 theme-text mb-3"></textarea>
                                <button type="submit"
                                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Actualizar Estado
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
