<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelsRatings extends Model
{
    use HasFactory;

    protected $table = 'models_ratings';

    public $timestamps = false;


    protected $fillable = [
        'id',
        'points',
        'flaga',
        'model_id',
        'judge_id'
    ];
}
