<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EdificacionZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.edificaciones_app';
    protected $primaryKey = 'id_edificacion';

    public function getGeom()
    {
        return json_decode(
            DB::connection($this->connection)
                ->table($this->table)
                ->select(DB::raw("public.ST_AsGeoJSON(public.ST_ForcePolygonCCW(geom)) as geom"))
                ->where('id_edificacion', $this->id_edificacion)
                ->first()->geom,
            true
        );
    }

}
