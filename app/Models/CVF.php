<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CVF extends Model
{
    use HasFactory;

    protected $table = 'bot_cvf';
    protected $primaryKey = "dni";
    protected $guarded = ['*'];
}
