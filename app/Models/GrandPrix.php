<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrandPrix extends Model
{
    use HasFactory;

    protected $table = 'grand_prixes';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'points',
        'flaga',
        'model_id',
        'judge_id'
    ];
}
