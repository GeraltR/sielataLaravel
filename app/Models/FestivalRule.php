<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FestivalRule extends Model
{
    use HasFactory;

    protected $table = 'festival_rule';
    protected $fillable = [
        'festival_edition_id',
        'title',
        'content',
    ];
    public function festivalEdition()
    {
        return $this->belongsTo(FestivalEdition::class);
    }
}
