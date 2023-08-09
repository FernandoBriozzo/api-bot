<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NombreCalle extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $table = 'nombre_calle';
}
