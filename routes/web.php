<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
//use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\HabitacionesController;
use App\Http\Controllers\PaginaController; // Asegúrate de importar tu controlador
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\ServicioAdicionalController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\PayPalController; // Asegúrate de importar tu controlador de PayPal
use App\Http\Controllers\AdminController; // Asegúrate de importar tu controlador de PayPal
use App\Http\Controller\DashboardPrincipalController;
use App\Http\Controller\BuscadorHabitacionesController;
use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\HabitacionDashboardController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\AdminDashboardController; // Nuevo nombre del controlador
use App\Http\Controllers\Admin\UserController; // Nuevo nombre del controlador
use Illuminate\Http\Request; // Importa la clase Request correcta
use App\Models\User; // Importa el modelo User
use App\Http\Controllers\Admin\AdminHabitacionController; // Nuevo nombre del controlador
use App\Models\Habitacion; // Importa el modelo Habitacion
use App\Http\Controllers\Admin\AdminReservaController; // Nuevo nombre del controlador
use App\Models\Reserva; // Importa el modelo User
use App\Http\Controllers\Admin\ServicioController; // Nuevo nombre del controlador
use App\Models\Servicio; // Importa el modelo User
use App\Http\Controllers\Admin\ReporteController; // Nuevo nombre del controlador


Route::middleware(['auth'])->prefix('admin')->group(function () {
    // ... otras rutas del panel ...

    // Rutas para reportes y estadísticas
    Route::get('/reportes', function (Request $request) {
        if (isAdmin()) {
            return (new ReporteController)->index($request); // Crea el controlador ReporteController
        }
        return redirect('/');
    })->name('admin.reportes.index'); 


 // Rutas para exportar reportes
 Route::get('/reportes/exportar-pdf', function (Request $request) {
    if (isAdmin()) {
        return (new ReporteController)->exportarPDF($request);
    }
    return redirect('/');
})->name('admin.reportes.exportarPDF');

Route::get('/reportes/exportar-excel', function (Request $request) {
    if (isAdmin()) {
        return (new ReporteController)->exportarExcel($request);
    }
    return redirect('/');
})->name('admin.reportes.exportarExcel');
});


Route::middleware(['auth'])->prefix('admin')->group(function () {
    // ... otras rutas del panel ...

    // Rutas para la gestión de servicios adicionales
    Route::get('/servicios', function (Request $request) {
        if (isAdmin()) {
            return (new ServicioController)->index($request);
        }
        return redirect('/');
    })->name('admin.servicios.index');

    Route::get('/servicios/crear', function (Request $request) {
        if (isAdmin()) {
            return (new ServicioController)->create($request);
        }
        return redirect('/');
    })->name('admin.servicios.create');

    Route::post('/servicios', function (Request $request) {
        if (isAdmin()) {
            return (new ServicioController)->store($request);
        }
        return redirect('/');
    })->name('admin.servicios.store');

    Route::get('/servicios/{servicio}/editar', function (Servicio $servicio) { 
        if (isAdmin()) {
            return (new ServicioController)->edit($servicio); 
        }
        return redirect('/');
    })->name('admin.servicios.edit');

    Route::put('/servicios/{servicio}', function (Request $request, Servicio $servicio) { // Asegúrate de importar el modelo Servicio
        if (isAdmin()) {
            return (new ServicioController)->update($request, $servicio);
        }
        return redirect('/');
    })->name('admin.servicios.update');

    Route::delete('/servicios/{servicio}', function (Servicio $servicio) { 
        if (isAdmin()) {
            return (new ServicioController)->destroy($servicio); 
        }
        return redirect('/');
    })->name('admin.servicios.destroy');
});



Route::middleware(['auth'])->prefix('admin')->group(function () {
    // ... otras rutas ...

    Route::get('/reservas', [AdminReservaController::class, 'index'])->name('admin.reservas.index');

    Route::get('/reservas/crear', [AdminReservaController::class, 'create'])->name('admin.reservas.create');

    Route::post('/reservas', [AdminReservaController::class, 'store'])->name('admin.reservas.store');

    Route::get('/reservas/{reserva}/editar', [AdminReservaController::class, 'edit'])->name('admin.reservas.edit');

    Route::put('/reservas/{reserva}', [AdminReservaController::class, 'update'])->name('admin.reservas.update');

    Route::delete('/reservas/{reserva}', [AdminReservaController::class, 'destroy'])->name('admin.reservas.destroy'); 
});












Route::middleware(['auth'])->prefix('admin')->group(function () {
    // ... otras rutas del panel ...

    // Rutas para la gestión de habitaciones
    Route::get('/habitaciones', function (Request $request) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->index($request);
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.index');

    Route::get('/habitaciones/crear', function (Request $request) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->create($request);
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.create');

    Route::post('/habitaciones', function (Request $request) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->store($request);
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.store');

    Route::get('/habitaciones/{habitacion}/editar', function (Request $request, Habitacion $habitacion) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->edit($habitacion); // Pasa solo $habitacion
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.edit');

    Route::put('/habitaciones/{habitacion}', function (Request $request, Habitacion $habitacion) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->update($request, $habitacion);
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.update');

    Route::delete('/habitaciones/{habitacion}', function (Request $request, Habitacion $habitacion) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->destroy($request, $habitacion);
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.destroy');

    Route::delete('/habitaciones/{habitacion}', function (Request $request, Habitacion $habitacion) {
        if (isAdmin()) {
            return (new AdminHabitacionController)->destroy($habitacion); // Pasa solo $habitacion
        } else {
            return redirect('/');
        }
    })->name('admin.habitaciones.destroy');
});


Route::middleware(['auth'])->prefix('admin')->group(function () { 
    // ... otras rutas del panel ...

    // Rutas para la gestión de usuarios
    Route::get('/usuarios', function (Request $request) {
        if (isAdmin()) {
            return (new UserController)->index($request);
        } else {
            return redirect('/');
        }
    })->name('admin.usuarios.index');

    Route::get('/usuarios/crear', function (Request $request) {
        if (isAdmin()) {
            return (new UserController)->create($request); 
        } else {
            return redirect('/');
        }
    })->name('admin.usuarios.create');

    Route::post('/usuarios', function (Request $request) {
        if (isAdmin()) {
            return (new UserController)->store($request); 
        } else {
            return redirect('/');
        }
    })->name('admin.usuarios.store');

    Route::get('/usuarios/{usuario}/editar', function (Request $request, User $usuario) {
    // ...
    return (new UserController)->edit($usuario); // Pasa solo $usuario
    // ...
})->name('admin.usuarios.edit');

Route::delete('/usuarios/{usuario}', function (Request $request, User $usuario) {
    if (isAdmin()) {
        return (new UserController)->destroy($usuario); // Pasa solo $usuario
    } else {
        return redirect('/');
    }
})->name('admin.usuarios.destroy');



    Route::put('/usuarios/{usuario}', function (Request $request, User $usuario) { 
        if (isAdmin()) {
            return (new UserController)->update($request, $usuario); // Pasa $request y $usuario
        } else {
            return redirect('/');
        }
    })->name('admin.usuarios.update');
   
});



Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->middleware('auth'); 


Route::get('/habitacion/{id}/reseñas', [HabitacionController::class, 'obtenerReseñas']);
Route::get('/perfil/mis-reservas', [PerfilController::class, 'misReservas'])->name('perfil.mis-reservas');

Route::get('/reseñas/create/{reserva}', [App\Http\Controllers\ReseñaController::class, 'create'])->name('reseñas.create');
Route::post('/reseñas', [App\Http\Controllers\ReseñaController::class, 'store'])->name('reseñas.store');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed'])
    ->name('verification.verify');

Route::get('/habitaciones/buscar', [BuscadorHabitacionesController::class, 'buscar'])->name('habitaciones.buscar');

Route::get('/reservas/buscar-vista', function () {
    return view('reservas.buscar');
})->name('reservas.buscar-vista');
Route::get('/cancelar-reserva/{reserva}', [ReservaController::class, 'cancelar'])->name('reservas.cancelar');Route::get('/reservas/buscar', [ReservaController::class, 'buscarPorCodigo'])->name('reservas.buscar_codigo');
Route::get('/habitaciones/disponibilidad', [App\Http\Controllers\BuscadorHabitacionesController::class, 'verificarDisponibilidad'])->name('habitaciones.disponibilidad');
Route::get('/habitaciones/buscar', [App\Http\Controllers\BuscadorHabitacionesController::class, 'buscar'])->name('habitaciones.buscar');
Route::get('/dashboard/habitaciones/{id}', [HabitacionDashboardController::class, 'show'])->name('habitaciones.dashboard');
Route::get('/reservas/{reserva}', [ReservaController::class, 'show'])->name('reservas.show');
Route::get('/admin/ganancias/{habitacion}', [AdminController::class, 'ganancias'])->name('admin.ganancias');
Route::get('/paypal/create', [PayPalController::class, 'create'])->name('paypal.create');
Route::post('/paypal/store', [PayPalController::class, 'store'])->name('paypal.store');
Route::get('/paypal/success', [PayPalController::class, 'success'])->name('paypal.success');
Route::get('/paypal/cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::prefix('pagos')->group(function () {
    Route::get('/', [PagoController::class, 'index'])->name('pagos.index');
    Route::get('/create', [PagoController::class, 'create'])->name('pagos.create');
    Route::post('/store', [PagoController::class, 'procesarPago'])->name('pagos.store');
    Route::get('/confirmacion', [PagoController::class, 'confirmarPago'])->name('pagos.confirmacion');
    Route::get('/error', [PagoController::class, 'error'])->name('pagos.error');
});


Route::get('/reservas/confirmacion', [ReservaController::class, 'confirmarReserva'])->name('reservas.confirmacion');
Route::get('/reservas/confirmacion', [ReservaController::class, 'confirmarReserva'])->name('reservas.confirmacion');
Route::get('/pagos/create', [PagoController::class, 'create'])->name('pagos.create');
//Route::post('/pagos', [PagoController::class, 'procesarPago'])->name('pagos.store');
Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
Route::get('/pagos/confirmacion', [PagoController::class, 'confirmarPago'])->name('pagos.confirmacion');

//Route::get('/reservas/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
Route::get('reservas/create/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::resource('servicios', ServicioAdicionalController::class);

//Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store');
//Route::get('/reservar/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones');

// Ruta de registro con cierre de sesión si el usuario está autenticado y no ha verificado su correo
Route::get('/register', function () {
    if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
        Auth::logout(); // Cierra la sesión del usuario no verificado
    }
    return app(RegisteredUserController::class)->create();
})->name('register');
Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});
Route::get('/habitaciones/create', [HabitacionController::class, 'create'])->name('habitaciones.create');

Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones/create', [HabitacionController::class, 'create'])->name('habitaciones.create');
Route::post('/habitaciones', [HabitacionController::class, 'store'])->name('habitaciones.store');


// Ruta del Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
   // Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de verificación de correo electrónico
// Rutas de verificación de correo electrónico
//Route::get('/habitaciones', [PaginaController::class, 'showHabitaciones'])->name('habitaciones');

// Asegúrate de que HabitacionesController exista y tenga un método llamado index
Route::get('/habitaciones', [HabitacionesController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');


// Ruta de prueba de logging
Route::get('/log-test', function () {
    \Log::info("Prueba de logs desde la ruta /log-test");
    return "Log de prueba ejecutado";
});
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');
Route::get('/habitaciones/{id}', [HabitacionController::class, 'show'])->name('habitaciones.show');

require __DIR__.'/auth.php';