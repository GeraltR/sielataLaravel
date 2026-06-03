<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FestivalEdition;

class FestivalTopicController extends Controller
{
    public function current()
    {
        $festival = FestivalEdition::where('active', true)->first();

        if (!$festival) {
            return response()->json([]);
        }

        $topics = $festival->topics()
            ->where('active', true)
            ->orderBy('order')
            ->get();

        return response()->json(
            $topics->map(function ($topic) {
                return [
                    'id' => $topic->id,

                    'title' => $topic->title,

                    'subtitle' => $topic->subtitle,

                    'description' => $topic->description,

                    'image' => $topic->image
                        ? asset('storage/' . $topic->image)
                         : null,
                    'image_position' => $topic->image_position,
                    'fade_width' => $topic->fade_width,
                    'order' => $topic->order,
                    'anniversary_value' => $topic->anniversary_value,
                    'anniversary_period' => $topic->anniversary_period,
                ];
            })
        );
    }
}
