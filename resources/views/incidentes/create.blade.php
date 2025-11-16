<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('incidentes.index') }}"
                class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h2 class="font-semibold text-xl theme-text leading-tight">
                {{ __('Crear Nuevo Incidente') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="theme-card rounded-lg shadow-sm overflow-hidden">
                <!-- Header del Formulario -->
                <div class="bg-gradient-to-r from-[var(--primary)] to-[var(--accent)] p-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-white/20 rounded-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white">Reportar Incidente</h3>
                            <p class="text-white/90 text-sm">Complete los detalles del incidente de infraestructura</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario -->
                <form method="POST" action="{{ route('incidentes.store') }}" class="p-6 space-y-6">
                    @csrf

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
                            <!-- Título -->
                            <div class="md:col-span-2">
                                <label for="titulo" class="block text-sm font-medium theme-text mb-2">
                                    Título del Incidente <span class="text-red-600">*</span>
                                </label>
                                <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required
                                    placeholder="Ej: Puerta del salón A101 no abre"
                                    class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                              focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
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
                                <select id="categoria_id" name="categoria_id" required
                                    class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                               focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                                               @error('categoria_id') border-red-500 @enderror">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
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
                                <select id="prioridad" name="prioridad" required
                                    class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                               focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                                               @error('prioridad') border-red-500 @enderror">
                                    <option value="">Seleccione prioridad</option>
                                    <option value="baja" {{ old('prioridad') == 'baja' ? 'selected' : '' }}>
                                        🟢 Baja - Puede esperar varios días
                                    </option>
                                    <option value="media" {{ old('prioridad') == 'media' ? 'selected' : '' }}
                                        selected>
                                        🟡 Media - Requiere atención pronto
                                    </option>
                                    <option value="alta" {{ old('prioridad') == 'alta' ? 'selected' : '' }}>
                                        🟠 Alta - Requiere atención urgente
                                    </option>
                                    <option value="urgente" {{ old('prioridad') == 'urgente' ? 'selected' : '' }}>
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
                            <select id="salon_id" name="salon_id"
                                class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                           focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent">
                                <option value="">No aplica / Área general</option>
                                @foreach ($salones->groupBy('bloque.nombre') as $bloqueNombre => $salonesBloque)
                                    <optgroup label="{{ $bloqueNombre }}">
                                        @foreach ($salonesBloque as $salon)
                                            <option value="{{ $salon->id }}"
                                                {{ old('salon_id') == $salon->id ? 'selected' : '' }}>
                                                {{ $salon->codigo }} - Piso {{ $salon->piso }}
                                                ({{ ucfirst($salon->tipo) }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-muted">Seleccione el salón si el incidente está relacionado con
                                un espacio específico</p>
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
                            <textarea id="descripcion" name="descripcion" rows="6" required
                                placeholder="Describa con el mayor detalle posible el problema que encontró. Incluya:
- ¿Qué sucede exactamente?
- ¿Desde cuándo ocurre?
- ¿Afecta las actividades académicas?
- Cualquier otro detalle relevante"
                                class="w-full rounded-lg border theme-bd px-4 py-3 theme-text
                                             focus:ring-2 focus:ring-[var(--primary)] focus:border-transparent
                                             @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Información de Ayuda -->
                    <div
                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <h5 class="font-semibold text-blue-900 dark:text-blue-300 mb-1">¿Qué sucede después?
                                </h5>
                                <ul class="text-sm text-blue-800 dark:text-blue-400 space-y-1">
                                    <li>• Su incidente será revisado por el equipo de infraestructura</li>
                                    <li>• Recibirá un código de seguimiento único</li>
                                    <li>• Un operativo será asignado según la prioridad</li>
                                    <li>• Podrá hacer seguimiento del estado en tiempo real</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de Acción -->
                    <div class="flex items-center justify-end gap-4 pt-4 border-t theme-bd">
                        <a href="{{ route('incidentes.index') }}"
                            class="px-6 py-3 bg-gray-200 dark:bg-gray-700 theme-text rounded-lg
                                  hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors font-medium">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-3 bg-[var(--primary)] text-white rounded-lg
                                       hover:bg-[var(--accent)] transition-colors font-medium
                                       flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Crear Incidente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
