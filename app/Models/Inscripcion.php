<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'bot_inscripcion';
    protected $guarded = ['*'];

    public static function estado() {
        $inscripcion = (new static)->first();
        $hoy = date('Y-m-d H:i:s');
        if (!$inscripcion == null) {
            $inscripcion->fecha_hasta == null ? $fecha_hasta = $hoy: $fecha_hasta = $inscripcion->fecha_hasta;
            if ($fecha_hasta >= $hoy)
            return "Abierta";
        } else {
            return "Cerrada";
        }
    }
}
