<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class models_ratings extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'points',
        'flaga',
        'model_id',
        'judge_id'
    ]
}