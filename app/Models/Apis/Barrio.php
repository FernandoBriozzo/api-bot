<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Barrio extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $primaryKey = 'id_renabap';

    protected $casts = [
        'id_loc_t2' => 'string'
    ];

    public function geometry(): HasOne
    {
        return $this->hasOne(BarrioGeom::class, 'id_renabap');
    }

    public function localidad() {
        $idLoc = $this['id_loc_t2'];
        $loc = Localidad::where('id_loc_t2', $idLoc)->first();
        return $loc['nombre'];
    }

    public function departamento() {
        $idDpto = substr($this['id_loc_t2'], 0, 5);
        $dpto = Departamento::where('id_dpto', $idDpto)->first();
        return $dpto['nombre'];
    }

    public function provincia() {
        $idProv = substr($this['id_loc_t2'], 0, 2);
        $prov = Provincia::where('id_prov', $idProv)->first();
        return $prov['nombre'];
    }

    public static function barriosPorLocalidad($id) {
        $localidades = (new static)
        ->select('id_renabap', 'nombre_barrio')->where('id_loc_t2', $id)->get();
        return $localidades;
    }
}
