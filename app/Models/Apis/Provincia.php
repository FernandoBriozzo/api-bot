<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $primaryKey = 'id_prov';

    protected $casts = [
        'id_prov' => 'string'
    ];

    public static function getNombres () {
        $response = (new static)
            ->select('id_prov', 'nombre')
            ->get();
        return $response;
    }
}
