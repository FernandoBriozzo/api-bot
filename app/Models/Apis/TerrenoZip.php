<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TerrenoZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.terrenos_app';
    protected $primaryKey = 'id_terreno';

    public function getGeom()
    {
        return json_decode(
            DB::connection($this->connection)
                ->table($this->table)
                ->select(DB::raw("public.ST_AsGeoJSON(public.ST_ForcePolygonCCW(geom)) as geom"))
                ->where('id_terreno', $this->id_terreno)
                ->first()->geom,
            true
        );
    }

    public function edificaciones(): HasMany
    {
        return $this->hasMany(EdificacionZip::class, 'id_terreno', 'id_terreno');
    }
}
