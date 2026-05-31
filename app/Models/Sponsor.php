<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    /** @use HasFactory<\Database\Factories\SponsorFactory> */
    use HasFactory;

    protected $table = 'sponsor';

    protected $fillable = [
        'name',
        'category',
        'logo',
        'url',
        'order',
        'active',
    ];
}
