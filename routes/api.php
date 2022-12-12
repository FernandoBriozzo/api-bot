<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\PiezaController;
use Database\Seeders\PiezaSeeder;

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
    Route::post('/datos-persona', [BotController::class, 'obtenerDatosCVF']);
    Route::post('/dni-con-cvf', [BotController::class, 'dniConCvf']);
    Route::post('/dni-sin-cvf', [BotController::class, 'dniSinCvf']);
});

Route::group(['prefix' => 'mi-pieza', 'middleware' => 'auth:sanctum'], function(){
    Route::post('/datos-persona', [PiezaController::class, 'obtenerDatosMiPieza']);
    Route::post('/estado-inscripcion', [PiezaController::class, 'checkInscripcionAbierta']);
    Route::post('/personas-certificado', [PiezaController::class, 'obtenerPersonaConCVF']);
    Route::post('/estado-baja', [PiezaController::class, 'estadoBaja']);
    Route::post('/numero-tramite', [PiezaController::class, 'numeroTramite']);
    Route::post('/depositos-tiempo', [PiezaController::class, 'cuandoDepositan']);
    Route::post('/depositos-cuenta', [PiezaController::class, 'dondeDepositan']);
    Route::post('/segunto-desembolso', [PiezaController::class, 'pedirSegundoDesembolso']);
    Route::post('/depositos-sin-acceso', [PiezaController::class, 'depositoInaccesible']);
    Route::post('/obras', [PiezaController::class, 'obrasARealizar']);
    Route::post('/dificultades-descarga', [PiezaController::class, 'dificultadesDescargarCVF']);
    Route::post('/victimas-robo', [PiezaController::class, 'victimaDeRobo']);
    Route::post('/respuestas-incorrectas', [PiezaController::class, 'equivoacionRespuesta']);
});

Route::post('/login', [BotController::class, 'login']);