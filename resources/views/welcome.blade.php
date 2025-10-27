<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Sistema de Tickets - FESC</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            /* ! tailwindcss v3.2.4 | MIT License | https://tailwindcss.com */*,::after,::before{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}::after,::before{--tw-content:''}html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;tab-size:4;font-family:Figtree, sans-serif;font-feature-settings:normal}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;font-weight:inherit;line-height:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}[type=button],[type=reset],[type=submit],button{-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0;padding:0}legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}textarea{resize:vertical}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]{display:none}*, ::before, ::after{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::-webkit-backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgb(59 130 246 / 0.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: }.fixed{position:fixed}.absolute{position:absolute}.relative{position:relative}.inset-0{inset:0}.z-10{z-index:10}.z-20{z-index:20}.mx-auto{margin-left:auto;margin-right:auto}.my-4{margin-top:1rem;margin-bottom:1rem}.mb-2{margin-bottom:0.5rem}.mb-3{margin-bottom:0.75rem}.mb-4{margin-bottom:1rem}.mb-6{margin-bottom:1.5rem}.mb-8{margin-bottom:2rem}.ml-2{margin-left:0.5rem}.ml-4{margin-left:1rem}.mt-2{margin-top:0.5rem}.mt-4{margin-top:1rem}.mt-6{margin-top:1.5rem}.mt-8{margin-top:2rem}.flex{display:flex}.inline-flex{display:inline-flex}.grid{display:grid}.hidden{display:none}.h-10{height:2.5rem}.h-12{height:3rem}.h-16{height:4rem}.h-20{height:5rem}.h-24{height:6rem}.h-full{height:100%}.min-h-screen{min-height:100vh}.w-10{width:2.5rem}.w-auto{width:auto}.w-full{width:100%}.max-w-2xl{max-width:42rem}.max-w-4xl{max-width:56rem}.max-w-6xl{max-width:72rem}.flex-1{flex:1 1 0%}.flex-col{flex-direction:column}.flex-wrap{flex-wrap:wrap}.items-center{align-items:center}.justify-center{justify-content:center}.gap-2{gap:0.5rem}.gap-3{gap:0.75rem}.gap-4{gap:1rem}.gap-6{gap:1.5rem}.overflow-hidden{overflow:hidden}.rounded-full{border-radius:9999px}.rounded-lg{border-radius:0.5rem}.rounded-xl{border-radius:0.75rem}.border{border-width:1px}.border-red-200{--tw-border-opacity:1;border-color:rgb(254 202 202 / var(--tw-border-opacity))}.bg-red-50{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.bg-red-500{--tw-bg-opacity:1;background-color:rgb(239 68 68 / var(--tw-bg-opacity))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-white\/90{background-color:rgb(255 255 255 / 0.9)}.bg-white\/95{background-color:rgb(255 255 255 / 0.95)}.bg-cover{background-size:cover}.bg-center{background-position:center}.bg-no-repeat{background-repeat:no-repeat}.object-contain{object-fit:contain}.object-cover{object-fit:cover}.p-3{padding:0.75rem}.p-4{padding:1rem}.p-6{padding:1.5rem}.p-8{padding:2rem}.px-3{padding-left:0.75rem;padding-right:0.75rem}.px-4{padding-left:1rem;padding-right:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.px-8{padding-left:2rem;padding-right:2rem}.py-2{padding-top:0.5rem;padding-bottom:0.5rem}.py-3{padding-top:0.75rem;padding-bottom:0.75rem}.py-4{padding-top:1rem;padding-bottom:1rem}.py-6{padding-top:1.5rem;padding-bottom:1.5rem}.py-8{padding-top:2rem;padding-bottom:2rem}.text-center{text-align:center}.text-2xl{font-size:1.5rem;line-height:2rem}.text-3xl{font-size:1.875rem;line-height:2.25rem}.text-base{font-size:1rem;line-height:1.5rem}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:0.875rem;line-height:1.25rem}.text-xl{font-size:1.25rem;line-height:1.75rem}.text-xs{font-size:0.75rem;line-height:1rem}.font-bold{font-weight:700}.font-semibold{font-weight:600}.leading-relaxed{line-height:1.625}.leading-tight{line-height:1.25}.text-gray-600{--tw-text-opacity:1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-800{--tw-text-opacity:1;color:rgb(31 41 55 / var(--tw-text-opacity))}.text-red-500{--tw-text-opacity:1;color:rgb(239 68 68 / var(--tw-text-opacity))}.text-red-600{--tw-text-opacity:1;color:rgb(220 38 38 / var(--tw-text-opacity))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255 / var(--tw-text-opacity))}.underline{text-decoration-line:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.shadow-2xl{--tw-shadow:0 25px 50px -12px rgb(0 0 0 / 0.25);--tw-shadow-colored:0 25px 50px -12px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-lg{--tw-shadow:0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 10px 15px -3px var(--tw-shadow-color), 0 4px 6px -4px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.shadow-md{--tw-shadow:0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color), 0 2px 4px -2px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow)}.backdrop-blur-sm{--tw-backdrop-blur:blur(4px);-webkit-backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia);backdrop-filter:var(--tw-backdrop-blur) var(--tw-backdrop-brightness) var(--tw-backdrop-contrast) var(--tw-backdrop-grayscale) var(--tw-backdrop-hue-rotate) var(--tw-backdrop-invert) var(--tw-backdrop-opacity) var(--tw-backdrop-saturate) var(--tw-backdrop-sepia)}.transition{transition-property:color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;transition-timing-function:cubic-bezier(0.4, 0, 0.2, 1);transition-duration:150ms}.hover\:bg-red-50:hover{--tw-bg-opacity:1;background-color:rgb(254 242 242 / var(--tw-bg-opacity))}.hover\:bg-red-600:hover{--tw-bg-opacity:1;background-color:rgb(220 38 38 / var(--tw-bg-opacity))}.hover\:text-red-700:hover{--tw-text-opacity:1;color:rgb(185 28 28 / var(--tw-text-opacity))}.focus\:outline:focus{outline-style:solid}.focus\:outline-2:focus{outline-width:2px}.focus\:outline-red-500:focus{outline-color:#ef4444}@media (min-width: 640px){.sm\:mb-0{margin-bottom:0}.sm\:block{display:block}.sm\:flex{display:flex}.sm\:h-24{height:6rem}.sm\:grid-cols-2{grid-template-columns:repeat(2, minmax(0, 1fr))}.sm\:flex-row{flex-direction:row}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:text-left{text-align:left}.sm\:text-4xl{font-size:2.25rem;line-height:2.5rem}.sm\:text-base{font-size:1rem;line-height:1.5rem}.sm\:text-xl{font-size:1.25rem;line-height:1.75rem}}@media (min-width: 768px){.md\:my-0{margin-top:0;margin-bottom:0}.md\:mb-8{margin-bottom:2rem}.md\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.md\:p-8{padding:2rem}.md\:px-8{padding-left:2rem;padding-right:2rem}.md\:text-2xl{font-size:1.5rem;line-height:2rem}.md\:text-5xl{font-size:3rem;line-height:1}}@media (min-width: 1024px){.lg\:grid-cols-3{grid-template-columns:repeat(3, minmax(0, 1fr))}.lg\:px-8{padding-left:2rem;padding-right:2rem}}

            /* Estilos personalizados */
        </style>
    </head>
    <body class="antialiased" style="background-image: url('{{ asset('images/FESC.JPG') }}'); background-size: cover; background-position: center; background-repeat: no-repeat; background-attachment: fixed;">
        <!-- Contenedor principal con imagen de fondo -->
        <div class="relative min-h-screen">
            <!-- Overlay para mejorar legibilidad -->
            <div class="absolute inset-0 bg-white/90"></div>

            <!-- Contenido -->
            <div class="relative z-10 min-h-screen flex flex-col">
                <!-- Contenido principal -->
                <div class="flex-1 flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8">
                    <div class="max-w-6xl w-full">
                        <!-- Logo y Título -->
                        <div class="text-center mb-8 md:mb-8">
                            <div class="flex justify-center mb-6">
                                <img src="{{ asset('images/fesc-30.png') }}" alt="Logo FESC" class="h-16 sm:h-24 w-auto object-contain">
                            </div>
                            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-800 mb-3 leading-tight">
                                Sistema de Tickets<br>
                                <span class="text-red-600">FESC</span>
                            </h1>
                            <p class="text-base sm:text-xl text-gray-600 leading-relaxed px-4">
                                Gestión de Anomalías y Reportes en Aulas
                            </p>
                        </div>

                        <!-- Call to Action -->
                        <div class="text-center">
                            @guest
                                <p class="text-gray-700 mb-4 text-sm sm:text-base md:text-lg px-4">
                                    Para comenzar a utilizar el sistema, por favor inicie sesión o regístrese
                                </p>
                                <div class="flex flex-col sm:flex-row justify-center gap-3 px-4 py-4">
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 md:px-8 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-lg hover:bg-red-600 focus:outline focus:outline-2 focus:outline-red-500 transition text-sm md:text-base">
                                        Iniciar Sesión
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 md:px-8 py-3 bg-white text-red-500 font-semibold rounded-lg shadow-lg border border-red-500 hover:bg-red-50 focus:outline focus:outline-2 focus:outline-red-500 transition text-sm md:text-base">
                                            Registrarse
                                        </a>
                                    @endif
                                </div>
                            @else
                                <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-6 md:px-8 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-lg hover:bg-red-600 focus:outline focus:outline-2 focus:outline-red-500 transition text-sm md:text-base">
                                    Ir al Dashboard
                                </a>
                            @endguest
                        </div>

                        <!-- Descripción del Sistema -->
                        <div class="bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl p-6 md:p-8 mb-6">
                            <h2 class="text-xl md:text-2xl font-semibold text-gray-800 mb-4 text-center">
                                Bienvenido al Sistema de Gestión de Aulas
                            </h2>
                            <p class="text-gray-700 text-sm sm:text-base md:text-lg leading-relaxed text-center mb-6 px-2">
                                Este sistema permite reportar y gestionar de manera eficiente las anomalías y situaciones que se presentan en las aulas de la Fundación de Estudios Superiores Comfanorte (FESC).
                            </p>

                            <!-- Cards de funcionalidades -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mt-6">
                                <!-- Card 1 -->
                                <div class="text-center p-4 md:p-6 bg-red-50 rounded-lg border border-red-200 transition hover:shadow-md">
                                    <div class="text-red-500 mb-3">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Reportar Anomalías</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Equipos dañados, aires acondicionados, problemas eléctricos</p>
                                </div>

                                <!-- Card 2 -->
                                <div class="text-center p-4 md:p-6 bg-red-50 rounded-lg border border-red-200 transition hover:shadow-md">
                                    <div class="text-red-500 mb-3">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Control de Acceso</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Apertura y cierre de salones, horarios de uso</p>
                                </div>

                                <!-- Card 3 -->
                                <div class="text-center p-4 md:p-6 bg-red-50 rounded-lg border border-red-200 transition hover:shadow-md sm:col-span-2 lg:col-span-1">
                                    <div class="text-red-500 mb-3">
                                        <svg class="w-10 h-10 md:w-12 md:h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">Trazabilidad</h3>
                                    <p class="text-xs md:text-sm text-gray-600">Seguimiento completo de todos los reportes y eventos</p>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <!-- Footer -->
                <div class="p-4 sm:p-6 text-center text-xs sm:text-sm text-gray-600">
                    <p>&copy; {{ date('Y') }} FESC - Fundación de Estudios Superiores Comfanorte</p>
                    <p class="mt-2">Creador: Santiago Rueda Quintero</p>
                </div>
            </div>
        </div>
    </body>
</html>
