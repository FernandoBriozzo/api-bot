<?php

use App\Http\Controllers\novedadesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return "Hello World!";
});

Route::get('/url/{barrio}', [novedadesController::class, 'makeZipBarrios']);
Route::get('/actualizar', [novedadesController::class, 'actualizarBarrios']);
Route::get('/actualizar-persona/{barrio}', [novedadesController::class, 'makeZipPersonas']);
Route::get('/actualizar-personas', [novedadesController::class, 'actualizarPersonas']);