<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-sm text-gray-600">
                Gracias por registrarte. Antes de continuar, revisa tu correo electrónico para verificar tu cuenta.
                Si no recibiste el correo, te enviaremos otro con el enlace de verificación.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    Se ha enviado un nuevo enlace de verificación a tu dirección de correo electrónico.
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <div>
                        <button class="btn btn-primary">
                            Reenviar enlace de verificación
                        </button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="underline text-sm text-gray-600 hover:text-gray-900">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
