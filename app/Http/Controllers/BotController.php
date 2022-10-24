<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaria;
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
}
