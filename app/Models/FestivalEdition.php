<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FestivalTopic;
use App\Helpers\Roman;

class FestivalEdition extends Model
{
    use HasFactory;

    protected $table = 'festival_edition';

    protected $fillable = [
        'edition',
        'title',
        'slug',
        'city',
        'location',
        'rok',
        'registration_start',
        'registration_end',
        'edit_cutoff',
        'festival_start',
        'festival_end',
        'results_at',
        'active',
    ];

    public function topics()
    {
        return $this->hasMany(FestivalTopic::class);
    }

    public function getDisplayEdition(): string
    {
        return Roman::fromInt($this->edition);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->getDisplayEdition() . ' ' . $this->title;
    }
}