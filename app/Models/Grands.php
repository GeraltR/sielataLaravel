<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grands extends Model
{
    use HasFactory;

    //protected $table = "grands";

    protected $fillable = [
        'id',
        'users_id',
        'categories_id',
        'model_id',
        'prixes_id'
    ];
}
