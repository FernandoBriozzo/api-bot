<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    protected $table = 'bot_encuestas';
    protected $primaryKey = 'dni';
    protected $guarded = ['*'];
    
}
