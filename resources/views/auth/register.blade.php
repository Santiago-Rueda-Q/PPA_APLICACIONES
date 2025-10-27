<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: url('{{ asset('images/FESC.JPG') }}');">
        <div class="bg-white/90 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-full max-w-md">
            <div class="text-center mb-6">
                <img src="{{ asset('images/fesc-30.png') }}" alt="FESC" class="h-16 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-[#8E1616]">Pre-Registro FESC</h2>
                <p class="text-sm text-gray-600 mt-1">Complete sus datos para solicitar acceso</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nombre completo')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="email" :value="__('Correo institucional')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="password" :value="__('Contraseña')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                                name="password_confirmation" required />
                </div>

                <x-primary-button class="w-full justify-center bg-[#8E1616] hover:bg-[#D84040]">
                    {{ __('Enviar Preregistro') }}
                </x-primary-button>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline hover:text-[#8E1616]">
                        ¿Ya tiene cuenta? Inicie sesión
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
