<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarrioGeom extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $table = 'barrios_geom';
    protected $primaryKey = 'id_renabap';
}
