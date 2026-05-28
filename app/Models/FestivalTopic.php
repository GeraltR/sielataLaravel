<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FestivalEdition;

class FestivalTopic extends Model
{
    /** @use HasFactory<\Database\Factories\FestivalTopicFactory> */
    use HasFactory;

    protected $table = 'festival_topic';

    protected $fillable = [
        'festival_edition_id',
        'title',
        'subtitle',
        'description',
        'image',
        'order',
        'active',
    ];

    public function festivalEdition()
    {
        return $this->belongsTo(FestivalEdition::class);
    }
}
