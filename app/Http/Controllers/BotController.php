<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaria;
use App\Models\CVF;
use App\Models\User;
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

    public function obtenerDatosDNI(Request $request)
    {
        //Todo: devolver las distintas posiblidades de busqueda de dni segun el diagrama
        $beneficiaria = Beneficiaria::find($request->dni);
        if (isset($beneficiaria)) {
            $nombre = $beneficiaria->nombre;
            $apellido = $beneficiaria->apellido;
            return response()->json([
                'mensaje' => "$nombre $apellido. Tus datos son correctos?",
            ]);
        } else {
            return response()->json([
                'mensaje' => "No tenemos registro de ese DNI. Escribilo nuevamente."
            ]);
        }
    }

    public function comprobarCVF(Request $request)
    {
        $beneficiaria = Beneficiaria::find($request->dni);
        $tieneCVF = $beneficiaria->tiene_cvf;
        if ($tieneCVF) {            
            return response()->json([
                'mensaje' => 'Posee CVF'
            ]);
        } else {
            return response()->json([
                'mensaje' => "No posee CVF."
            ]);
        }
    }

    public function obtenerDatosCVF (Request $request) {
        $usuario = CVF::find($request->dni);
        if ($usuario == null) {
            return response()->json([], 204);
        }
        $tieneCVF = $usuario->tiene_cvf;
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        return response()->json([
            'nombre' => $nombre,
            'apellido' => $apellido,
            'tiene_cvf' => (bool)$tieneCVF
        ], 200);
    }

    public function dniConCvf (Request $request) {
        $usuario = CVF::find($request->dni);
        if(!$usuario->tiene_cvf) {
            return response()->json([
                'message' => 'Esta persona no posee CVF'
            ], 200);
        }
        $solicitudF02 = $usuario->f02;
        $solicitudF03 = $usuario->f03;
        $solicitudF04 = $usuario->f04;
        $solicitudF05 = $usuario->f05;
        return response()->json([
            'solicitud_F02' => $solicitudF02,
            'solicitud_F03' => $solicitudF03,
            'solicitud_F04' => $solicitudF04,
            'solicitud_F05' => $solicitudF05
        ], 200);
    }

    public function dniSinCvf (Request $request) {
        $usuario = CVF::find($request->dni);
        if($usuario->tiene_cvf) {
            return response()->json([
                'message' => 'Esta persona posee CVF'
            ], 200);
        }
        $solicitudF01 = $usuario->f01;
        $encuesta = (bool)$usuario->encuesta_realizada;
        return response()->json([
            'solicitud_F01' => $solicitudF01,
            'encuesta_realizada' => $encuesta
        ], 200);
    }
}
