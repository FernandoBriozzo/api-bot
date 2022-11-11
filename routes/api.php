<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\PiezaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cvf', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/obtener-datos', [BotController::class, 'obtenerDatosCVF']);
    Route::post('/consultar-dni-con-cvf', [BotController::class, 'dniConCvf']);
    Route::post('/consultar-dni-sin-cvf', [BotController::class, 'dniSinCvf']);
});

Route::group(['prefix' => 'mi-pieza', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/obtener-datos', [PiezaController::class, 'ObtenerDatos']);
    Route::post('/comprobar-inscripta', [PiezaController::class, 'checkInscripcion']);
    Route::post('/estado-inscripcion', [PiezaController::class, 'checkInscripcionAbierta']);
    Route::post('/otra-inscripta', [PiezaController::class, 'inscriptaCVF']);
    Route::post('/buscar-beneficiaria', [PiezaController::class, 'buscarBeneficiaria']);
    Route::post('/comprobar-numero-tramite', [PiezaController::class, 'comprobarTramite']);
    Route::post('/consultar-etapa', [PiezaController::class, 'consultarEtapa']);
});

Route::post('/login', [BotController::class, 'login']);
Route::post('/obtener-datos-dni', [BotController::class, 'obtenerDatosDNI'])->middleware('auth:sanctum');
Route::post('/comprobar-cvf', [BotController::class, 'comprobarCVF'])->middleware('auth:sanctum');