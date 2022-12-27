<?php

namespace App\Http\Controllers;

use App\Models\CVF;
use App\Models\User;
use App\Models\Reclamo;
use App\Models\Encuesta;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class BotController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()->json([
                'message' => 'Datos de login inválidos.'
            ], 401);
        }
        $user = User::where('name', $request['name'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function obtenerDatosCVF(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $usuario = CVF::find($request->dni);
        if ($usuario == null) {
            return response()->json([], 204);
        }
        $nombre = $usuario->apellido_nombre;
        $cvf = $usuario->nro_certificado;
        return response()->json([
            'nombre_apellido:' => $nombre,
            'numero_certificado:' => $cvf
        ], 200);
    }
        
    public function dniSinCvf(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $usuario = Reclamo::find($request->dni);
        $encuesta = Encuesta::find($request->dni);
        return response()->json([
            'F01' => $usuario != null? $usuario->f01(): "No posee F01 pendiente.",
            'tiene_encuesta' => $encuesta == null ? false: true
        ], 200);
    }

    public function dniConCvf(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $reclamo = Reclamo::find($request->dni);
        $respuesta = $reclamo->reclamos();
        return response()->json([
            'reclamos' => $respuesta
        ], 200);
    }
}
