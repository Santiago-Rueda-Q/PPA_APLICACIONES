<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('incidentes.show', $incidente) }}"
               class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h2 class="font-semibold text-xl theme-text leading-tight">
                    Editar Incidente {{ $incidente->codigo }}
                </h2>
                <p class="text-sm text-[var(--text-secondary)]">Modifique la información del incidente</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="theme-card rounded-lg shadow-sm overflow-hidden">

                <!-- Header del Formulario -->
                <div class="bg-gradient-to-r from-yellow-600 to-orange-600 p-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Editar Incidente</h3>
                            <p class="text-white/90 text-sm">Actualice la información necesaria</p>
                        </div>
                    </div>
                </div>

                <!-- Alerta de Estado -->
                @if($incidente->estado !== 'pendiente')
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-yellow-900 dark:text-yellow-300">Nota Importante</h4>
                                <p class="text-sm text-yellow-800 dark:text-yellow-400 mt-1">
                                    Este incidente ya ha sido procesado ({{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}).
                                    Los cambios pueden afectar el seguimiento actual.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Formulario -->
                <form method="POST" action="{{ route('incidentes.update', $incidente) }}" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Información Básica -->
                    <div>
                        <h4 class="text-lg font-semibold theme-text mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Información Básica
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Código (Solo lectura) -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium theme-text mb-2">
                                    Código del Incidente
                                </label>
                                <div class="px-4 py-3 bg-gray-100 dark:bg-gray-800 rounded-lg border theme-bd">
                                    <span class="font-mono font-semibold theme-text">{{ $incidente->codigo }}</span>
                                </div>
                            </div>

                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="titulo" class="block text-sm font-medium theme-text mb-2">
                                    Título del Incidente <span class="text-red-600">*</span>
                                </label>
                                <input type="text"
                                       id="titulo"
                                       name="titulo"
                                       value="{{ old('titulo', $incidente->titulo) }}"
                                       required
                                       placeholder="Ej: Puerta del salón A101 no abre"
                                       class="w-full rounded-lg border theme-bd px-4 py-3 text-black
                                              focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                              @error('titulo') border-red-500 @enderror">
                                @error('titulo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Categoría -->
                            <div>
                                <label for="categoria_id" class="block text-sm font-medium theme-text mb-2">
                                    Categoría <span class="text-red-600">*</span>
                                </label>
                                <select id="categoria_id"
                                        name="categoria_id"
                                        required
                                        class="w-full rounded-lg border theme-bd px-4 py-3 text-black
                                               focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                               @error('categoria_id') border-red-500 @enderror">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                                {{ old('categoria_id', $incidente->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoria_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prioridad -->
                            <div>
                                <label for="prioridad" class="block text-sm font-medium theme-text mb-2">
                                    Prioridad <span class="text-red-600">*</span>
                                </label>
                                <select id="prioridad"
                                        name="prioridad"
                                        required
                                        class="w-full rounded-lg border theme-bd px-4 py-3 text-black
                                               focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                               @error('prioridad') border-red-500 @enderror">
                                    <option value="">Seleccione prioridad</option>
                                    <option value="baja" {{ old('prioridad', $incidente->prioridad) == 'baja' ? 'selected' : '' }}>
                                        🟢 Baja - Puede esperar varios días
                                    </option>
                                    <option value="media" {{ old('prioridad', $incidente->prioridad) == 'media' ? 'selected' : '' }}>
                                        🟡 Media - Requiere atención pronto
                                    </option>
                                    <option value="alta" {{ old('prioridad', $incidente->prioridad) == 'alta' ? 'selected' : '' }}>
                                        🟠 Alta - Requiere atención urgente
                                    </option>
                                    <option value="urgente" {{ old('prioridad', $incidente->prioridad) == 'urgente' ? 'selected' : '' }}>
                                        🔴 Urgente - Requiere atención inmediata
                                    </option>
                                </select>
                                @error('prioridad')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ubicación -->
                    <div>
                        <h4 class="text-lg font-semibold theme-text mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Ubicación
                        </h4>

                        <div>
                            <label for="salon_id" class="block text-sm font-medium theme-text mb-2">
                                Salón (Opcional)
                            </label>
                            <select id="salon_id"
                                    name="salon_id"
                                    class="w-full rounded-lg border theme-bd px-4 py-3 text-black
                                           focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <option value="">No aplica / Área general</option>
                                @foreach($salones->groupBy('bloque.nombre') as $bloqueNombre => $salonesBloque)
                                    <optgroup label="{{ $bloqueNombre }}">
                                        @foreach($salonesBloque as $salon)
                                            <option value="{{ $salon->id }}"
                                                    {{ old('salon_id', $incidente->salon_id) == $salon->id ? 'selected' : '' }}>
                                                {{ $salon->codigo }} - Piso {{ $salon->piso }} ({{ ucfirst($salon->tipo) }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-[var(--text-muted)]">
                                Actual:
                                @if($incidente->salon)
                                    <span class="font-semibold">{{ $incidente->salon->codigo }}</span>
                                @else
                                    <span class="italic">No especificado</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <h4 class="text-lg font-semibold theme-text mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Descripción Detallada
                        </h4>

                        <div>
                            <label for="descripcion" class="block text-sm font-medium theme-text mb-2">
                                Describa el problema <span class="text-red-600">*</span>
                            </label>
                            <textarea id="descripcion"
                                      name="descripcion"
                                      rows="6"
                                      required
                                      placeholder="Describa con el mayor detalle posible el problema..."
                                      class="w-full rounded-lg border theme-bd px-4 py-3 text-black
                                             focus:ring-2 focus:ring-yellow-500 focus:border-transparent
                                             @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $incidente->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información del Solicitante (Solo lectura) -->
                    <div class="bg-gray-50 dark:bg-gray-800/50 rounded-lg p-4">
                        <h4 class="text-sm font-semibold theme-text mb-3">Información Original</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div>
                                <span class="text-[var(--text-secondary)]">Solicitante:</span>
                                <p class="theme-text font-medium mt-1">{{ $incidente->solicitante->name }}</p>
                            </div>
                            <div>
                                <span class="text-[var(--text-secondary)]">Fecha de Creación:</span>
                                <p class="theme-text font-medium mt-1">{{ $incidente->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-[var(--text-secondary)]">Estado Actual:</span>
                                <p class="mt-1">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $incidente->estado_badge_color }}">
                                        {{ ucfirst(str_replace('_', ' ', $incidente->estado)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Información de Advertencia -->
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h5 class="font-semibold text-blue-900 dark:text-blue-300 mb-1">Sobre las Modificaciones</h5>
                                <ul class="text-sm text-blue-800 dark:text-blue-400 space-y-1">
                                    <li>• Los cambios se registrarán en el historial del incidente</li>
                                    <li>• Si necesita cambiar el estado, use la opción "Cambiar Estado" en la vista de detalles</li>
                                    <li>• Las modificaciones pueden requerir nueva revisión según el estado actual</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-between gap-4 pt-4 border-t theme-bd">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('incidentes.show', $incidente) }}"
                               class="px-6 py-3 bg-gray-200 dark:bg-gray-700 theme-text rounded-lg
                                      hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
                                Cancelar
                            </a>

                            @can('delete', $incidente)
                                <button type="button"
                                        onclick="if(confirm('¿Está seguro de eliminar este incidente? Esta acción no se puede deshacer.')) { document.getElementById('delete-form').submit(); }"
                                        class="px-6 py-3 bg-red-600 text-white rounded-lg
                                               hover:bg-red-700 transition-colors font-medium">
                                    Eliminar
                                </button>
                            @endcan
                        </div>

                        <button type="submit"
                                class="px-6 py-3 bg-yellow-600 text-white rounded-lg
                                       hover:bg-yellow-700 transition-colors font-medium
                                       flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar Cambios
                        </button>
                    </div>
                </form>

                <!-- Formulario de Eliminación (oculto) -->
                @can('delete', $incidente)
                    <form id="delete-form"
                          method="POST"
                          action="{{ route('incidentes.destroy', $incidente) }}"
                          class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                @endcan
            </div>

            <!-- Información Adicional -->
            <div class="mt-6 theme-card rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold theme-text mb-4">Información de Auditoría</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <span class="text-[var(--text-secondary)]">Creado</span>
                            <p class="theme-text font-medium">{{ $incidente->created_at->format('d/m/Y H:i:s') }}</p>
                            <p class="text-xs text-[var(--text-secondary)]">{{ $incidente->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <div>
                            <span class="text-[var(--text-secondary)]">Última Modificación</span>
                            <p class="theme-text font-medium">{{ $incidente->updated_at->format('d/m/Y H:i:s') }}</p>
                            <p class="text-xs text-[var(--text-secondary)]">{{ $incidente->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
