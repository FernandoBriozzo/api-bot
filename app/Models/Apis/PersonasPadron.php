<?php

namespace App\Models\Apis;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasPadron extends Model
{
    use HasFactory;

    protected $connection = 'arsat';
    protected $table = 'personas_padron';
}
