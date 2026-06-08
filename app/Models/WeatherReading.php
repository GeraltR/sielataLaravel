<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherReading extends Model
{
    protected $fillable = [
        'recorded_at', 
        'temp', 
        'humidity', 
        'pressure', 
        'wind', 
        'rain'
    ];
}
