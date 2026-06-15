<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastGrands extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'users_id',
        'categories_id',
        'model_id',
        'prixes_id',
        'year'
    ];
}
