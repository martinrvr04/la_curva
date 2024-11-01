<!-- resources/views/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-blue-600 text-white py-4">
            <div class="container mx-auto flex justify-between items-center px-6">
                <h1 class="text-3xl font-semibold">Dashboard</h1>
                <!-- Formulario para el cierre de sesión -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <!-- Enlace de cierre de sesión -->
                <a href="{{ route('logout') }}" class="text-white underline"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                   Cerrar sesión
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8 flex-1">
            <h2 class="text-2xl font-bold mb-6">Bienvenido, {{ Auth::user()->nombre }}!</h2>
            <p class="text-gray-700">Este es tu dashboard, donde puedes ver información importante de tu cuenta y gestionar tus actividades.</p>
            <!-- Agrega más contenido del dashboard aquí -->
        </main>
    </div>

</body>
</html>
