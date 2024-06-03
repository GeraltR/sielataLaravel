<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Uzytkownik extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'uzytkownik';
    public $timestamps = false;

    protected $fillable = [
        'imie',
        'nazwisko',
        'login',
        'email',
        'password',
        'rokur',
        'data',
        'miasto',
        'klub',
        'admin',
        'isteacher'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
