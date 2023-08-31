<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $table = 'localidades';
    protected $primaryKey = 'id_loc_t2';

    protected $casts = [
        'id_loc_t2' => 'string'
    ];

    public static function localidadesPorDepartamento($id) {
        $localidades = (new static)
        ->select('id_loc_t2', 'nombre')->where('id_loc_t2', 'like', "$id%")->get();
        return $localidades;
    }
}
