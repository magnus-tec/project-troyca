<?php

use App\Http\Controllers\AporteAhorrosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EstadoDeCuentaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistroSocioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'role:admin|user'])
    ->name('dashboard');

Route::group(['middleware' => ['role:admin|user']], function () {

    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::get('permissions/{permissionId}/delete', [App\Http\Controllers\PermissionController::class, 'destroy']);

    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
    Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::get('users/{userId}/delete', [App\Http\Controllers\UserController::class, 'destroy']);

    // ESTADO DE CUENTA
    Route::resource('prestamos', EstadoDeCuentaController::class);
    Route::get('/prestamo/{id}/pdf', [EstadoDeCuentaController::class, 'generarPDF'])->name('prestamo-pdf');
    Route::get('/prestamo/{id}/pagar', [EstadoDeCuentaController::class, 'generarPago'])->name('prestamo-pagar');
    Route::get('/prestamo/pagar-cuota/{id}', [EstadoDeCuentaController::class, 'pagarCuota'])->name('prestamo-pagarCuota');

    // APORTE Y AHORROS
    Route::resource('aportes', AporteAhorrosController::class);
    Route::get('/aporte/{id}/pdf', [AporteAhorrosController::class, 'generarPDF'])->name('aporte-pdf');
    Route::get('/aporte/totalAportes/{id}', [AporteAhorrosController::class, 'totalAportes'])->name('obtener-total-aporte');

    // SOCIOS 
    Route::resource('socios', RegistroSocioController::class);
    Route::get('/registro/{registro}/pdf', [RegistroSocioController::class, 'generarPDF'])->name('registro.generar-pdf');

    //BENEFICIARIOS
    Route::resource('beneficiarios', App\Http\Controllers\BeneficiariosController::class);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
