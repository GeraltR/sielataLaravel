<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastRegisteredModels extends Model
{
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
        'categories_id',
        'year'
    ];
}
