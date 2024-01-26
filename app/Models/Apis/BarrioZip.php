<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarrioZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.barrios_app';
    protected $primaryKey = 'id_renabap';

    public static function getBarriosByFecha($fechaInicial, $fechaFinal)
    {
        $barrios = (new static)->whereBetween('fecha_ultima_actualizacion', [$fechaInicial, $fechaFinal])->get();
        return $barrios;
    }

    public function getGeom()
    {
        return json_decode(
            DB::connection($this->connection)
                ->table($this->table)
                ->select(DB::raw("public.ST_AsGeoJSON(public.ST_ForcePolygonCCW(geom)) as geom"))
                ->where('id_renabap', $this->id_renabap)
                ->first()->geom,
            true
        );
    }

    public function manzanas(): HasMany
    {
        return $this->hasMany(ManzanaZip::class, 'id_renabap', 'id_renabap');
    }
}
