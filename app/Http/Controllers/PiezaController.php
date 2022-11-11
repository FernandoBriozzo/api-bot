<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pieza;

class PiezaController extends Controller
{
    public function ObtenerDatos(Request $request)
    {
        $usuario = Pieza::find($request->dni);
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

    public function checkInscripcion(Request $request) {
        $usuario = Pieza::find($request->dni);
        if ($usuario == null) {
            return response()->json([], 204);
        }
        $estaInscripta = (bool)$usuario->inscripta_mipieza;
        $esGanadora = (bool)$usuario->es_ganadora;
        $deBaja = (bool)$usuario->de_baja;
        $situacionDni = $usuario->situacion_dni;
        return response()->json([
            'esta_inscripta' => $estaInscripta,
            'es_ganadora' => $esGanadora,
            'de_baja' => $deBaja,
            'situacion_dni' => $situacionDni
        ], 200);
    }

    public function checkInscripcionAbierta(){
        $inscripcion = (bool)Pieza::find('999999999')->inscripcion_abierta;
        return response()->json([
            'inscripcion_abierta' => $inscripcion
        ], 200);

    }

    public function inscriptaCVF(Request $request) {
        $BeneficiariaInscripta = Pieza::where([['cvf', $request->cvf],['inscripta_mipieza', true]])->first();
        if ($BeneficiariaInscripta == null) {
            $otraInscripta = false;
        } else {
            $otraInscripta = true;
        }
        return response()->json([
            'otra-inscripta' => $otraInscripta
        ], 200);
    }

    public function buscarBeneficiaria(Request $request) {
        $beneficiaria = Pieza::where([['dni', $request->dni],['cvf', $request->cvf]])->first();
        if ($beneficiaria == null) {
            $esBeneficiaria = false;
        } else {
            $esBeneficiaria = true;
        }
        return response()->json([
            'es-beneficiaria' => $esBeneficiaria
        ], 200);
    }

    public function comprobarTramite(Request $request) {
        $usuario = Pieza::find($request->dni);
        $tramite = $usuario->nro_tramite_dni;
        if ($tramite == $request->numero_tramite) {
            $coincide = true;
        } else {
            $coincide = false;
        }

        return response()->json([
            'tramite_coincide_dni' => $coincide
        ], 200);
    }

    public function consultarEtapa(Request $request) {
        $usuario = Pieza::find($request->dni);
        if ($usuario == null) {
            return response()->json([], 204);
        }
        $etapa = $usuario->estado_etapa;
        $pago = $usuario->situacion_pago;
        return response()->json([
            'etapa' => $etapa,
            'situacion_pago' => $pago
        ], 200);
    }
}
