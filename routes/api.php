<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AporteAhorrosController;
use App\Http\Controllers\EstadoDeCuentaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroSocioController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->get('socios/findAll', [RegistroSocioController::class, 'findAll']);
//APIS ESTADO CUENTA
Route::middleware(['auth:sanctum'])->get('estado_cuenta/findAll', [EstadoDeCuentaController::class, 'findAll']);
Route::middleware(['auth:sanctum'])->get('estado_cuenta/{id}', [EstadoDeCuentaController::class, 'findOne']);
// Route::middleware(['auth:sanctum'])->get('prestamo/generarPDF/{id}', [EstadoDeCuentaController::class, 'generarPDFBase64']);
Route::middleware(['auth:sanctum'])->get('prestamo/generarPDF/{id}', [EstadoDeCuentaController::class, 'generarPDF']);
Route::middleware(['auth:sanctum'])->put('cuotas/{id}/pagar', [EstadoDeCuentaController::class, 'pagarCuotaApi']);
Route::middleware(['auth:sanctum'])->get('socios/disponibles', [EstadoDeCuentaController::class, 'getSociosDisponibles']);
Route::middleware(['auth:sanctum'])->post('estado_cuenta/create', [EstadoDeCuentaController::class, 'storePrestamo']);
//APIS APORTE AHORROS
Route::middleware(['auth:sanctum'])->get('aportes/findAll', [AporteAhorrosController::class, 'findAll']);
Route::middleware(['auth:sanctum'])->get('aportes/generarPDF/{id}', [AporteAhorrosController::class, 'generarPDF']);
Route::middleware(['auth:sanctum'])->post('aportes/create', [AporteAhorrosController::class, 'store']);
Route::middleware(['auth:sanctum'])->post('aportes/generar-voucher-pdf/{aporteDetalle}', [AporteAhorrosController::class, 'generarVoucher']);
Route::middleware(['auth:sanctum'])->get('aportes/totalAportes/{id}', [AporteAhorrosController::class, 'totalAportes']);
Route::middleware(['auth:sanctum'])->get('/buscar-socio/{dni}', [AporteAhorrosController::class, 'buscarSocio']);



Route::post('login', [AuthController::class, 'login'])->name('loginApi');
