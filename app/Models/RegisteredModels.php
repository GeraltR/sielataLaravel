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
        'Nazwa',
        'Producent',
        'Skala',
        'Styl',
        'konkurs',
        'wynik',
        'IdParent',
        'users_id',
        'categories_id'
    ];
}
