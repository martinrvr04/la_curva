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





// Rutas de autenticación
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

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
