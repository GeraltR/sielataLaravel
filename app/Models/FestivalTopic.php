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
        'anniversary_value',
        'anniversary_period',
        'title',
        'subtitle',
        'description',
        'image',
        'order',
        'active',
        'image_position',
        'fade_width',
    ];

    public function festivalEdition()
    {
        return $this->belongsTo(FestivalEdition::class);
    }
}
