<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'idkat';
    public $timestamps = false;

    protected $fillable = ['symbol', 'nazwa', 'klasa', 'rok', 'grupa', 'idparent'];

    protected $casts = [
        'rok'      => 'integer',
        'idparent' => 'integer',
    ];

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'idparent', 'idkat');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'idparent', 'idkat');
    }
}