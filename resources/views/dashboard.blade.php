<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl theme-text leading-tight">
                {{ __('Dashboard de Incidentes') }}
            </h2>

            <!-- Badge de Notificaciones -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <svg class="w-6 h-6 theme-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if($incidentesSinAtender > 0)
                        <span id="notification-badge"
                              class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                            {{ $incidentesSinAtender }}
                        </span>
                    @endif
                </div>

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
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Notificaciones Importantes -->
            @if(count($notificaciones) > 0)
                <div class="theme-card rounded-lg shadow-sm p-4">
                    @foreach($notificaciones as $notif)
                        <div class="flex items-center gap-3 p-3 rounded-lg mb-2
                                    {{ $notif['tipo'] === 'error' ? 'bg-red-50 dark:bg-red-900/20' : '' }}
                                    {{ $notif['tipo'] === 'warning' ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}
                                    {{ $notif['tipo'] === 'info' ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <svg class="w-5 h-5
                                        {{ $notif['tipo'] === 'error' ? 'text-red-600' : '' }}
                                        {{ $notif['tipo'] === 'warning' ? 'text-yellow-600' : '' }}
                                        {{ $notif['tipo'] === 'info' ? 'text-blue-600' : '' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="theme-text font-medium">{{ $notif['mensaje'] }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Estadísticas -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Total -->
                <div class="theme-card rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[var(--text-secondary)]">Total</p>
                            <p class="text-3xl font-bold theme-text">{{ $estadisticas['total'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <svg class="w-6 h-6 theme-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pendientes -->
                <div class="theme-card rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[var(--text-secondary)]">Pendientes</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] }}</p>
                        </div>
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/30 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- En Proceso -->
                <div class="theme-card rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[var(--text-secondary)]">En Proceso</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $estadisticas['en_proceso'] }}</p>
                        </div>
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Resueltos -->
                <div class="theme-card rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[var(--text-secondary)]">Resueltos</p>
                            <p class="text-3xl font-bold text-green-600">{{ $estadisticas['resueltos'] }}</p>
                        </div>
                        <div class="p-3 bg-green-100 dark:bg-green-900/30 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Cerrados -->
                <div class="theme-card rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-[var(--text-secondary)]">Cerrados</p>
                            <p class="text-3xl font-bold text-gray-600">{{ $estadisticas['cerrados'] }}</p>
                        </div>
                        <div class="p-3 bg-gray-100 dark:bg-gray-700 rounded-full">
                            <svg class="w-6 h-6 text-[var(--text-secondary)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incidentes por Prioridad -->
            <div class="theme-card rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold theme-text mb-4">Incidentes por Prioridad</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-600"></div>
                        <span class="theme-text">Urgente: <strong>{{ $estadisticas['por_prioridad']['urgente'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-orange-600"></div>
                        <span class="theme-text">Alta: <strong>{{ $estadisticas['por_prioridad']['alta'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-yellow-600"></div>
                        <span class="theme-text">Media: <strong>{{ $estadisticas['por_prioridad']['media'] }}</strong></span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-green-600"></div>
                        <span class="theme-text">Baja: <strong>{{ $estadisticas['por_prioridad']['baja'] }}</strong></span>
                    </div>
                </div>
            </div>

            <!-- Incidentes Recientes -->
            <div class="theme-card rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b theme-bd">
                    <h3 class="text-lg font-semibold theme-text">Incidentes Recientes</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Solicitante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Salón</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Prioridad</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium theme-text uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y theme-bd">
                            @forelse($incidentesRecientes as $incidente)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/30 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-sm theme-text">{{ $incidente->codigo }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="theme-text font-medium">{{ Str::limit($incidente->titulo, 40) }}</p>
                                        <p class="text-sm text-[var(--text-secondary)]">{{ $incidente->categoria->nombre }}</p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="theme-text">{{ $incidente->solicitante->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="theme-text">{{ $incidente->salon?->codigo ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->prioridad_badge_color }}">
                                            {{ ucfirst($incidente->prioridad) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->estado_badge_color }}">
                                            {{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--text-secondary)]">
                                        {{ $incidente->created_at->diffForHumans() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <a href="{{ route('incidentes.show', $incidente) }}"
                                           class="text-[var(--primary)] hover:text-[var(--accent)] font-medium">
                                            Ver detalles
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-8 text-center text-muted">
                                        No hay incidentes recientes
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-800/30 text-center">
                    <a href="{{ route('incidentes.index') }}"
                       class="text-[var(--primary)] hover:text-[var(--accent)] font-medium">
                        Ver todos los incidentes →
                    </a>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Actualizar conteo de notificaciones cada 30 segundos
        setInterval(async () => {
            try {
                const response = await fetch('{{ route("notificaciones.count") }}');
                const data = await response.json();

                const badge = document.getElementById('notification-badge');
                if (data.count > 0) {
                    if (badge) {
                        badge.textContent = data.count;
                    } else {
                        // Crear badge si no existe
                        const svg = document.querySelector('svg.w-6.h-6.theme-text').parentElement;
                        const newBadge = document.createElement('span');
                        newBadge.id = 'notification-badge';
                        newBadge.className = 'absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse';
                        newBadge.textContent = data.count;
                        svg.appendChild(newBadge);
                    }
                } else if (badge) {
                    badge.remove();
                }
            } catch (error) {
                console.error('Error actualizando notificaciones:', error);
            }
        }, 30000); // 30 segundos
    </script>
    @endpush
</x-app-layout>
