<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\PiezaController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\LocalidadController;

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

Route::middleware('auth:sanctum', 'ability:bot,otrahabilidad')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'cvf', 'middleware' => ['auth:sanctum', 'ability:bot']], function(){
    Route::post('/datos-persona', [BotController::class, 'obtenerDatosCVF']);
    Route::post('/dni-con-cvf', [BotController::class, 'dniConCvf']);
    Route::post('/dni-sin-cvf', [BotController::class, 'dniSinCvf']);
});

Route::group(['prefix' => 'mi-pieza', 'middleware' => ['auth:sanctum', 'ability:bot']], function(){
    Route::post('/datos-persona', [PiezaController::class, 'obtenerDatosMiPieza']);
    Route::post('/estado-inscripcion', [PiezaController::class, 'checkInscripcionAbierta']);
    Route::post('/personas-certificado', [PiezaController::class, 'obtenerPersonaConCVF']);
    Route::post('/estado-persona', [PiezaController::class, 'estadoPersona']);
    Route::post('/numeros-tramite', [PiezaController::class, 'numeroTramite']);
    Route::post('/depositos-tiempo', [PiezaController::class, 'cuandoDepositan']);
    Route::post('/depositos-cuenta', [PiezaController::class, 'dondeDepositan']);
    Route::post('/segundo-desembolso', [PiezaController::class, 'pedirSegundoDesembolso']);
    Route::post('/depositos-sin-acceso', [PiezaController::class, 'depositoInaccesible']);
    Route::post('/obras', [PiezaController::class, 'obrasARealizar']);
    Route::post('/dificultades-descarga', [PiezaController::class, 'dificultadesDescargarCVF']);
    Route::post('/victimas-robo', [PiezaController::class, 'victimaDeRobo']);
    Route::post('/respuestas-incorrectas', [PiezaController::class, 'equivoacionRespuesta']);
});

Route::post('/login', [BotController::class, 'login']);

Route::group(['prefix' => 'barrios', 'middleware' => ['auth:sanctum', 'ability:salta']], function(){
    Route::get('/', [BarrioController::class, 'index']);
    Route::get('/{id}', [BarrioController::class, 'show']);
    Route::get('/{id}/geom', [BarrioController::class , 'geometria']);
    Route::get('/{id}/ubicacion', [BarrioController::class, 'ubicacion']);
});

Route::group(['prefix' => 'provincias', 'middleware' => ['auth:sanctum', 'ability:salta']], function(){
    Route::get('/', [ProvinciaController::class, 'index']);
    Route::get('/{id}', [ProvinciaController::class, 'show']);
    Route::get('/{id}/departamentos', [ProvinciaController::class, 'showDepartamentos']);
});

Route::group(['prefix' => 'departamentos', 'middleware' => ['auth:sanctum', 'ability:salta']], function(){
    Route::get('/', [DepartamentoController::class, 'index']);
    Route::get('/{id}', [DepartamentoController::class, 'show']);
    Route::get('/{id}/localidades', [DepartamentoController::class, 'showLocalidades']);
});

Route::group(['prefix' => 'localidades', 'middleware' => ['auth:sanctum', 'ability:salta']], function(){
    Route::get('/', [LocalidadController::class, 'index']);
    Route::get('/{id}', [LocalidadController::class, 'show']);
    Route::get('/{id}/barrios', [LocalidadController::class, 'showBarrios']);
});

Route::get('/checktokens', function(Request $request){
    return $request->user()->tokencan('salta');
})->middleware('auth:sanctum', 'ability:bot,salta');
