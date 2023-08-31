<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $primaryKey = 'id_dpto';

    protected $casts = [
        'id_dpto' => 'string'
    ];

    public static function getNombres () {
        $response = (new static)
            ->select('id_dpto', 'nombre')
            ->get();
        return $response;
    }

    public static function departamentosPorProvincia($id) {
        $response = (new static)
        ->select('id_dpto', 'nombre')->where('id_dpto', 'like', "$id%")->get();
        return $response;
    }
}
