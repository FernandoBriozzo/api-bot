<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonaZip extends Model
{
    use HasFactory;

    protected $connection = 'pgsql';
    protected $table = 'apis.personas_app';
    protected $primaryKey = 'dni';

    public function barrio(): BelongsTo
    {
        return $this->belongsTo(BarrioZip::class, 'id_barrio', 'id_renabap');
    }

    public static function getBarriosNovedades(){
        return (new static)->distinct('id_barrio')->select('id_barrio')->pluck('id_barrio');
    }

    public static function getCertificadosByBarrio(BarrioZip $barrio)
    {
        return (new static)->distinct('nro_certificado')->select('nro_certificado')->where('id_barrio', $barrio->id_renabap)->pluck('nro_certificado');
    }

    public static function getPersonasByCertificado($cvf)
    {
        $personas = (new static)->where('nro_certificado', $cvf)->get();
        $result = [];
        foreach ($personas as $persona) {
            $result[] = $persona;
        }
        return $result;
    }
}
