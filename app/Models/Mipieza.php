<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mipieza extends Model
{
    use HasFactory;

    protected $table = 'bot_mipieza';
    protected $primaryKey = 'dni';
    protected $guarded = ['*'];

    public function obtenerTipoBaja() {
        $respuesta = $this->select('tipo_persona', 'baja')->where('dni', $this->dni)->first();
        $tipoPersona = $respuesta->tipo_persona;
        $baja = $respuesta->baja;
        return ['tipo_persona' => $tipoPersona, 'baja' => $baja];
    }
}
