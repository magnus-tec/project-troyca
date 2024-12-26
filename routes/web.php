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
    Route::get('/estado-de-cuenta', [EstadoDeCuentaController::class, 'index'])->name('estado-de-cuenta');
    Route::get('/nuevo-prestamo', [EstadoDeCuentaController::class, 'create'])->name('registrar-prestamo');
    Route::post('/guardar-prestamo', [EstadoDeCuentaController::class, 'store'])->name('guardar-prestamo');
    Route::get('/prestamo/{id}/pdf', [EstadoDeCuentaController::class, 'generarPDF'])->name('prestamo-pdf');
    Route::get('/prestamo/{id}/pagar', [EstadoDeCuentaController::class, 'generarPago'])->name('prestamo-pagar');
    Route::get('/prestamo/pagar-cuota/{id}', [EstadoDeCuentaController::class, 'pagarCuota'])->name('prestamo-pagarCuota');

    // APORTE Y AHORROS

    Route::get('/aporte-ahorros', [AporteAhorrosController::class, 'index'])->name('aporte-ahorros');
    Route::get('/nuevo-aporte-ahorro', [AporteAhorrosController::class, 'create'])->name('registrar-aporte');
    Route::post('/guardar-aporte-ahorro', [AporteAhorrosController::class, 'store'])->name('guardar-aporte');
    Route::get('/aporte/totalAportes/{id}', [AporteAhorrosController::class, 'totalAportes'])->name('obtener-total-aporte');
    Route::post('/guardar-aporte', [AporteAhorrosController::class, 'store'])->name('guardar-aporte');
    Route::get('/aporte/{id}/pdf', [AporteAhorrosController::class, 'generarPDF'])->name('aporte-pdf');

    // SOCIOS 
    Route::get('/registrar-socios', [RegistroSocioController::class, 'index'])->name('registrar-socios');
    Route::get('/nuevo-registro', [RegistroSocioController::class, 'create'])->name('nuevo-registro');
    Route::post('/guardar-socio', [RegistroSocioController::class, 'store'])->name('guardar-socio');



    // Route::post('/registro/datos-personales', [RegistroSocioController::class, 'storeDatosPersonales'])->name('registro.datos-personales.store');
    // Route::get('/registro/datos-personales', [RegistroSocioController::class, 'create'])->name('registro.datos-personales');
    // Route::get('/registro/direccion', [RegistroSocioController::class, 'create'])->name('registro.direccion');
    // Route::post('/registro/direccion', [RegistroSocioController::class, 'storeDireccion'])->name('registro.direccion.store');
    // Route::get('/registro/laboral', [RegistroSocioController::class, 'create'])->name('registro.laboral');
    // Route::post('/registro/laboral', [RegistroSocioController::class, 'storeLaboral'])->name('registro.laboral.store');
    // Route::get('/registro/conyuge', [RegistroSocioController::class, 'create'])->name('registro.conyuge');
    // Route::post('/registro/conyuge', [RegistroSocioController::class, 'storeConyuge'])->name('registro.conyuge.store');
    // Route::get('/registro/beneficiarios', [RegistroSocioController::class, 'create'])->name('registro.beneficiarios');
    // Route::post('/registro/beneficiarios', [RegistroSocioController::class, 'storeBeneficiarios'])->name('registro.beneficiarios.store');
    Route::get('/registro/{registro}/edit', [RegistroSocioController::class, 'edit'])->name('registro.edit');
    Route::put('/registro/{registro}', [RegistroSocioController::class, 'update'])->name('registro.update');
    Route::delete('/registro/{registro}', [RegistroSocioController::class, 'destroy'])->name('registro.destroy');
    Route::get('/registro/{registro}/pdf', [RegistroSocioController::class, 'generarPDF'])->name('registro.generar-pdf');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
