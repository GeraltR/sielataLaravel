<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThankYouTemplate extends Model
{
    protected $table = 'thank_you_template';

    protected $fillable = [
        'content',
    ];
}
