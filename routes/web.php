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

Route::get('/habitaciones/disponibilidad', [App\Http\Controllers\BuscadorHabitacionesController::class, 'verificarDisponibilidad'])->name('habitaciones.disponibilidad');Route::get('/habitaciones/buscar', [App\Http\Controllers\BuscadorHabitacionesController::class, 'buscar'])->name('habitaciones.buscar');
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
Route::post('/pagos', [PagoController::class, 'procesarPago'])->name('pagos.store');
Route::get('/pagos', [PagoController::class, 'index'])->name('pagos.index');
Route::get('/pagos/confirmacion', [PagoController::class, 'confirmarPago'])->name('pagos.confirmacion');

Route::get('/reservas/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
Route::get('reservas/create/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
Route::post('/reservas', [ReservaController::class, 'store'])->name('reservas.store');
Route::resource('servicios', ServicioAdicionalController::class);

Route::post('/reservar', [ReservaController::class, 'store'])->name('reservas.store');
Route::get('/reservar/{habitacion}', [ReservaController::class, 'create'])->name('reservas.create');
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


Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

        Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
});
// Ruta de prueba de logging
Route::get('/log-test', function () {
    \Log::info("Prueba de logs desde la ruta /log-test");
    return "Log de prueba ejecutado";
});
Route::get('/habitaciones', [HabitacionController::class, 'index'])->name('habitaciones.index');

require __DIR__.'/auth.php';
