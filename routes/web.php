<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidenteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Legal Routes (Públicas)
|--------------------------------------------------------------------------
*/
Route::prefix('legal')->name('legal.')->group(function () {
    Route::get('/terms', [LegalController::class, 'terms'])->name('terms');
    Route::get('/privacy', [LegalController::class, 'privacy'])->name('privacy');
    Route::get('/data-protection', [LegalController::class, 'dataProtection'])->name('data-protection');
});

/*
|--------------------------------------------------------------------------
| Rutas Autenticadas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/notificaciones/count', [DashboardController::class, 'getNotificacionesCount'])
        ->name('notificaciones.count');

    // Incidentes
    Route::resource('incidentes', IncidenteController::class);

    // Rutas adicionales de incidentes
    Route::post('incidentes/{incidente}/asignar', [IncidenteController::class, 'asignar'])
        ->name('incidentes.asignar')
        ->middleware('can:assign,incidente');

    Route::post('incidentes/{incidente}/cambiar-estado', [IncidenteController::class, 'cambiarEstado'])
        ->name('incidentes.cambiar-estado')
        ->middleware('can:changeStatus,incidente');

    Route::post('incidentes/{incidente}/comentar', [IncidenteController::class, 'comentar'])
        ->name('incidentes.comentar')
        ->middleware('can:addComment,incidente');

    // Profile
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    // Password
    Route::post('/password/verify', [PasswordController::class, 'verify'])->name('password.verify');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| CONTROL DE USUARIOS (Solo SuperAdmin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:superadmin'])
    ->prefix('user-management')
    ->name('user-management.')
    ->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::post('{user}/approve', [UserManagementController::class, 'approve'])->name('approve');
        Route::delete('{user}/reject', [UserManagementController::class, 'reject'])->name('reject');
        Route::patch('{user}/deactivate', [UserManagementController::class, 'deactivate'])->name('deactivate');
        Route::put('{user}/update-role', [UserManagementController::class, 'updateRole'])->name('update-role');
        Route::delete('{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

require __DIR__.'/auth.php';
