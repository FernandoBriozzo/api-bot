<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reclamo extends Model
{
    use HasFactory;

    protected $table = 'bot_reclamos';
    protected $primaryKey = "dni";
    protected $guarded = ['*'];

    public function f01()
    {
        $f01Pendiente = ["1", "2", "24", "35", "36", "45", "53", "99"];
        $f01ProxEncuesta = ["27", "49"];
        $estado = $this->select('id_estado')->where('dni', $this->dni)->where('tiporeclamoid', 1)->orderBY('fecha', 'desc')->first();
        if ($estado == null) {
            $respuesta = "No posee F01 pendiente.";
        } else {
            if (in_array($estado->id_estado, $f01Pendiente)) {
                $respuesta = "Pendiente.";
            } else if (in_array($estado->id_estado, $f01ProxEncuesta)) {
                $respuesta = "Próximo de encuesta.";
            }
        }
        return $respuesta;
    }

    public function reclamos()
    {
        $resultado = [];
        $tipoReclamos = $this->select('tiporeclamoid')->where('dni', $this->dni)->distinct()->orderBy('tiporeclamoid')->get();
        foreach ($tipoReclamos as $reclamo) {
            //$estado = $this->select('id_estado')->where('dni', $this->dni)->where('tiporeclamoid', $reclamo->tiporeclamoid)->orderBy('fecha', 'desc')->first();
            $resultado[] = "F0" . $reclamo->tiporeclamoid;
        }
        return $resultado;
    }
}
