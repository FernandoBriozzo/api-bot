<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mipieza;
use App\Models\Inscripcion;

class PiezaController extends Controller
{
    public function obtenerDatosMiPieza(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $usuario = Mipieza::find($request->dni);
        if ($usuario == null) {
            return response()->json([], 204);
        }
        $nombre = $usuario->nombre;
        $apellido = $usuario->apellido;
        return response()->json([
            'apellido' => $apellido,
            'nombre' => $nombre
        ], 200);
    }

    public function checkInscripcionAbierta()
    {
        return response()->json([
            'estado_inscripcion' => Inscripcion::estado()
        ], 200);
    }

    public function obtenerPersonaConCVF(Request $request)
    {
        $personas = Mipieza::where('nro_certificado', $request->certificado)->get(); //todo cambiar esto al modelo
        if ($personas == null) {
            return response()->json([], 204);
        }
        return response()->json([
            'personas:' => $personas
        ], 200);
    }

    public function estadoBaja(Request $request)
    {
        $respuesta = MIpieza::select('tipo_persona', 'baja')->where('dni', $request->dni)->first();
        $tipoPersona = $respuesta->tipo_persona;
        $baja = $respuesta->baja;
        if ($tipoPersona == "S" || $tipoPersona == "I") {
            $mensaje = "Inscripta en Mi Pieza (no ganadora)";
        }
        if ($tipoPersona == "B") {
            $mensaje = "Tiene CVF. Es ganadora/beneficiaria vigente de Mi Pieza";
        }
        if ($tipoPersona == null) {
            switch ($baja) {
                case "G1":
                    $mensaje = "Baja Mi Pieza - No confirmación de subsidio";
                    break;
                case "G3":
                    $mensaje = "Baja Mi Pieza - Punto GPS fuera de barrio";
                    break;
                case "G4":
                    $mensaje = "Baja Mi Pieza - Desaprobación de acreditación de avance";
                    break;
                case "G5":
                    $mensaje = "Baja Mi Pieza - No validación de avance";
                    break;
                case "G6":
                    $mensaje = "Baja Mi Pieza - Incumplimiento Fin de obra";
                    break;
                case "G7":
                    $mensaje = "Baja Mi Pieza - Fallecimiento: baja";
                    break;
                case "G8":
                    $mensaje = "Baja Mi Pieza - Renuncia asistencia";
                    break;
            }
        }
        return response()->json([
            'respuesta:' => $mensaje
        ], 200);
    }

    public function numeroTramite(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        if ($request->numero_tramite == null) {
            return response()->json([
                'error' => "El campo numero_tramite es obligatorio"
            ], 400);
        }
        $numeroTramite = Mipieza::select('nro_tramite')->where('dni', $request->dni)->first();
        if ($numeroTramite == null) {
            $respuesta = "Incorrecto";
        } else if (str_pad($numeroTramite->nro_tramite, 11, 0, STR_PAD_LEFT) == str_pad($request->numero_tramite, 11, 0, STR_PAD_LEFT)) {
            $respuesta = "Correcto";
        } else $respuesta = "Incorrecto";
        return response()->json([
            'numero_tramite' => $respuesta
        ], 200);
    }

    public function cuandoDepositan(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $estado = Mipieza::select('etapa_id', 'id_estado_pago')->where('dni', $request->dni)->first();
        $etapa = $estado->etapa_id;
        $pago = $estado->id_estado_pago;
        if (!in_array($pago, ["4", "7"])) {
            switch ($etapa) {
                case "ID_2":
                    $respuesta = "Ganadoras/Inicio y Envío Confirmación";
                    break;
                case "ID_3":
                    $respuesta = "Ganadoras/Inicio y Envío Confirmación";
                    break;
                case "ID_4":
                    $respuesta = "Ganadoras/Inicio y Envío Confirmación";
                    break;
                case "ID_5":
                    $respuesta = "Transferencia realizada";
                    break;
                case "ID_6":
                    $respuesta = "Inicio validación avance";
                    break;
                case "ID_7":
                    $respuesta = "Envío validación avance";
                    break;
                case "ID_8":
                    $respuesta = "2da transferencia";
                    break;
                case "ID_9":
                    $respuesta = "Inicio validación fin de obra";
                    break;
                case "ID_12":
                    $respuesta = "Solicitud validación cuenta";
                    break;
                case "ID_13":
                    $respuesta = "Envío validación cuenta";
                    break;
                case "ID_14":
                    $respuesta = "Confirmación 1era transferencia";
                    break;
                case "ID_15":
                    $respuesta = "Confirmación 2da transferencia";
                    break;
            }
        }
        if ($pago == '4') {
            $respuesta = "Rechazo 1er depósito";
        }
        if ($pago == '7') {
            $respuesta = "Rechazo 2do depósito";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function dondeDepositan(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $etapa = Mipieza::select('etapa_id')->where('dni', $request->dni)->first()->etapa_id;
        if (in_array($etapa, ["ID_2", "ID_3", "ID_4", "ID_12"])) {
            $respuesta = "Ganadoras/Inicio-Envío Confirmación-Solicitud validación cuenta";
        } else {
            $respuesta = "Envío validación cuenta para adelante";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function pedirSegundoDesembolso(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $etapa = Mipieza::select('etapa_id')->where('dni', $request->dni)->first()->etapa_id;
        if (in_array($etapa, ["ID_2", "ID_3", "ID_4", "ID_12", "ID_13"])) {
            $respuesta = "Ganadoras a Envio val cuenta";
        } else if (in_array($etapa, ["ID_5", "ID_14", "ID_6", "ID_7"])) {
            $respuesta = "1era transferencia a Envío val avance";
        } else {
            $respuesta = "2da transferencia a Envío val obra";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function depositoInaccesible(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $estado = Mipieza::select('id_estado_pago')->where('dni', $request->dni)->first()->id_estado_pago;
        if ($estado == null || $estado == '1') {
            $respuesta = "No recibió ningún depósito";
        } else if ($estado == '2' || $estado == '5') {
            $respuesta = "1er o 2do depósito sin confirmación de Anses";
        } else if ($estado == '3') {
            $respuesta = "1er depósito confirmado por Anses";
        } else if ($estado == '6') {
            $respuesta = "2do depósito confirmado por Anses";
        } else if ($estado == '4' || $estado == '7') {
            $respuesta = "Rechazo de pago confirmado por Anses";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function equivoacionRespuesta(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $estado = Mipieza::select('id_estado_pago')->where('dni', $request->dni)->first()->id_estado_pago;
        switch ($estado) {
            case '2':
                $respuesta = "";
                break;
            case '3':
                $respuesta = "";
                break;
            case '4':
                $respuesta = "";
                break;
            case '5':
                $respuesta = "";
                break;
            case '6':
                $respuesta = "";
                break;
            case '7':
                $respuesta = "";
                break;
        }
        return response()->json([
            'pago_estado' => $estado
        ], 200);
    }

    public function dificultadesDescargarCVF(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }

        $etapa = Mipieza::select('etapa_id')->where('dni', $request->dni)->first();
        if ($etapa->etapa_id == "ID_10") {
            $respuesta = "Envío validación obra";
        } else if ($etapa->etapa_id == "ID_11") {
            $respuesta = "Fin de obra";
        } else {
            $respuesta = "Inicio validación obra o anterio";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function victimaDeRobo(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $etapa = Mipieza::select('etapa_id')->where('dni', $request->dni)->first();
        if (in_array($etapa->etapa_id, ["ID_2", "ID_3", "ID_4", "ID_12", "ID_13"])) {
            $respuesta = "Envío validación cuenta o anterior";
        } else if (in_array($etapa->etapa_id, ["ID_5", "ID_6", "ID_7", "ID_8", "ID_9", "ID_10", "ID_11", "ID_14", "ID_15"])) {
            $respuesta = "1era transferencia o posterior";
        }
        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }

    public function obrasARealizar(Request $request)
    {
        if ($request->dni == null) {
            return response()->json([
                'error' => 'El campo dni es obligatorio'
            ], 400);
        }
        $etapa = Mipieza::select('etapa_id')->where('dni', $request->dni)->first()->etapa_id;
        if (in_array($etapa, ["ID_2", "ID_3"])) {
            $respuesta = "Ganadores/Inicio Confirmación";
        } else {
            $respuesta = "Envío confirmación para adelante";
        }

        return response()->json([
            'respuesta' => $respuesta
        ], 200);
    }
}
