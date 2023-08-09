<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizacionesPadron extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $table = 'organizaciones_padron';
}
