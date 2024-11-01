<!-- resources/views/auth/register.blade.php -->

<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="nombre" class="block font-medium text-sm text-gray-700">Nombre</label>
                    <input id="nombre" class="block mt-1 w-full" type="text" name="nombre" value="{{ old('nombre') }}" required autofocus />
                </div>

                <!-- Apellido -->
                <div class="mt-4">
                    <label for="apellido" class="block font-medium text-sm text-gray-700">Apellido</label>
                    <input id="apellido" class="block mt-1 w-full" type="text" name="apellido" value="{{ old('apellido') }}" required />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <label for="email" class="block font-medium text-sm text-gray-700">Correo Electrónico</label>
                    <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block font-medium text-sm text-gray-700">Contraseña</label>
                    <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <label for="password_confirmation" class="block font-medium text-sm text-gray-700">Confirmar Contraseña</label>
                    <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                </div>

                <!-- Teléfono -->
                <div class="mt-4">
                    <label for="telefono" class="block font-medium text-sm text-gray-700">Teléfono</label>
                    <input id="telefono" class="block mt-1 w-full" type="text" name="telefono" value="{{ old('telefono') }}" />
                </div>

                <!-- País -->
                <div class="mt-4">
                    <label for="pais" class="block font-medium text-sm text-gray-700">País</label>
                    <input id="pais" class="block mt-1 w-full" type="text" name="pais" value="{{ old('pais') }}" />
                </div>

                <!-- Ciudad de Nacimiento -->
                <div class="mt-4">
                    <label for="ciudad_nacimiento" class="block font-medium text-sm text-gray-700">Ciudad de Nacimiento</label>
                    <input id="ciudad_nacimiento" class="block mt-1 w-full" type="text" name="ciudad_nacimiento" value="{{ old('ciudad_nacimiento') }}" />
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="mt-4">
                    <label for="fecha_nacimiento" class="block font-medium text-sm text-gray-700">Fecha de Nacimiento</label>
                    <input id="fecha_nacimiento" class="block mt-1 w-full" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        ¿Ya tienes una cuenta?
                    </a>

                    <button class="ml-4 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:outline-none focus:ring">
                        Registrarse
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
