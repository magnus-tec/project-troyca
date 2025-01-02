<?php

use App\Http\Controllers\Api\AuthController;
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
Route::middleware(['auth:sanctum'])->get('prestamo/pdf_base64/{id}', [EstadoDeCuentaController::class, 'generarPDFBase64']);
Route::middleware(['auth:sanctum'])->put('cuotas/{id}/pagar', [EstadoDeCuentaController::class, 'pagarCuotaApi']);
Route::middleware(['auth:sanctum'])->get('socios/disponibles', [EstadoDeCuentaController::class, 'getSociosDisponibles']);
Route::middleware(['auth:sanctum'])->post('estado_cuenta/create', [EstadoDeCuentaController::class, 'storePrestamo']);

Route::post('login', [AuthController::class, 'login'])->name('loginApi');
