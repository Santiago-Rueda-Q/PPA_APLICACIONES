<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl theme-text leading-tight">
                {{ __('Gestión de Incidentes') }}
            </h2>

            @can('incidentes.create')
                <a href="{{ route('incidentes.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-[var(--primary)] text-white rounded-lg hover:bg-[var(--accent)] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nuevo Incidente
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filtros -->
            <div class="theme-card rounded-lg shadow-sm p-4 mb-6">
                <form method="GET" action="{{ route('incidentes.index') }}"
                    class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Búsqueda -->
                    <div>
                        <input type="text" name="search" placeholder="Buscar por código o título..."
                            value="{{ request('search') }}"
                            class="w-full rounded-lg border theme-bd px-4 py-2 theme-text focus:ring-2 focus:ring-[var(--primary)]">
                    </div>

                    <!-- Estado -->
                    <div>
                        <select name="estado" class="w-full rounded-lg border theme-bd px-4 py-2 theme-text">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>
                                Pendiente</option>
                            <option value="asignado" {{ request('estado') === 'asignado' ? 'selected' : '' }}>Asignado
                            </option>
                            <option value="en_proceso" {{ request('estado') === 'en_proceso' ? 'selected' : '' }}>En
                                Proceso</option>
                            <option value="resuelto" {{ request('estado') === 'resuelto' ? 'selected' : '' }}>Resuelto
                            </option>
                            <option value="cerrado" {{ request('estado') === 'cerrado' ? 'selected' : '' }}>Cerrado
                            </option>
                        </select>
                    </div>

                    <!-- Prioridad -->
                    <div>
                        <select name="prioridad" class="w-full rounded-lg border theme-bd px-4 py-2 theme-text">
                            <option value="">Todas las prioridades</option>
                            <option value="urgente" {{ request('prioridad') === 'urgente' ? 'selected' : '' }}>Urgente
                            </option>
                            <option value="alta" {{ request('prioridad') === 'alta' ? 'selected' : '' }}>Alta
                            </option>
                            <option value="media" {{ request('prioridad') === 'media' ? 'selected' : '' }}>Media
                            </option>
                            <option value="baja" {{ request('prioridad') === 'baja' ? 'selected' : '' }}>Baja
                            </option>
                        </select>
                    </div>

                    <!-- Categoría -->
                    <div>
                        <select name="categoria" class="w-full rounded-lg border theme-bd px-4 py-2 theme-text">
                            <option value="">Todas las categorías</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ request('categoria') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Botones -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-[var(--primary)] text-white rounded-lg hover:bg-[var(--accent)] transition-colors">
                            Filtrar
                        </button>
                        <a href="{{ route('incidentes.index') }}"
                            class="px-4 py-2 bg-gray-200 dark:bg-gray-700 theme-text rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabla de Incidentes -->
            <div class="theme-card rounded-lg shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Solicitante
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Salón</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Categoría</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Prioridad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Asignado a</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y theme-bd">
                            @forelse($incidentes as $incidente)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="font-mono text-sm font-semibold theme-text">{{ $incidente->codigo }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="theme-text font-medium">{{ Str::limit($incidente->titulo, 50) }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="theme-text text-sm">{{ $incidente->solicitante->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="theme-text text-sm font-medium">{{ $incidente->salon?->codigo ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium"
                                            style="background-color: {{ $incidente->categoria->color }}22; color: {{ $incidente->categoria->color }}">
                                            {{ $incidente->categoria->nombre }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->prioridad_badge_color }}">
                                            {{ ucfirst($incidente->prioridad) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->estado_badge_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="theme-text text-sm">
                                            {{ $incidente->asignado?->name ?? 'Sin asignar' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-muted">
                                        {{ $incidente->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('incidentes.show', $incidente) }}"
                                                class="text-blue-600 hover:text-blue-800 font-medium"
                                                title="Ver detalles">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @can('update', $incidente)
                                                <a href="{{ route('incidentes.edit', $incidente) }}"
                                                    class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-12 text-center">
                                        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-muted text-lg">No se encontraron incidentes</p>
                                        @can('incidentes.create')
                                            <a href="{{ route('incidentes.create') }}"
                                                class="inline-block mt-4 text-[var(--primary)] hover:text-[var(--accent)] font-medium">
                                                Crear el primer incidente →
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                @if ($incidentes->hasPages())
                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800/30">
                        {{ $incidentes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
