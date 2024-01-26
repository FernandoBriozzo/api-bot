<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CalleZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.calles_app';
    protected $primaryKey = 'id';

    public static function getCallesById($id) {
        $id = (int)$id;
        $calles = (new static)->whereRaw("$id = any(id_renabap)")->get();
        return $calles;
    }

    public function getGeom() {
        return json_decode(
            DB::connection($this->connection)
                ->table($this->table)
                ->select(DB::raw("public.ST_AsGeoJSON(public.ST_ForcePolygonCCW(geom)) as geom"))
                ->where('id', $this->id)
                ->first()->geom,
            true
        );
    }
}
