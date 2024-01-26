<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManzanaZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.manzanas_app';
    protected $primaryKey = 'id_manzana';

    public function getGeom()
    {
        return json_decode(
            DB::connection($this->connection)
                ->table($this->table)
                ->select(DB::raw("public.ST_AsGeoJSON(public.ST_ForcePolygonCCW(geom)) as geom"))
                ->where('id_manzana', $this->id_manzana)
                ->first()->geom,
            true
        );
    }

    public function terrenos(): HasMany
    {
        return $this->hasMany(TerrenoZip::class, 'id_manzana', 'id_manzana');
    }
}
