<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisteredModels extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nazwa',
        'producent',
        'skala',
        'styl',
        'konkurs',
        'wynik',
        'idparent',
        'users_id',
        'categories_id'
    ];
}
