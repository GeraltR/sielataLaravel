<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FestivalEdition;

class FestivalController extends Controller
{
    public function current()
    {
        $festival = FestivalEdition::where('active', true)->first();

        if (!$festival) {
            return response()->json([
                'message' => 'No active festival edition found.'
            ], 404);
        }

        return response()->json([
            'id' => $festival->id,
            'edition' => $festival->getDisplayEdition(),
            'title' => $festival->title,
            'city' => $festival->city,
            'location' => $festival->location,
            'year' => $festival->rok,
            'registration_start' => $festival->registration_start,
            'registration_end' => $festival->registration_end,
            'festival_start' => $festival->festival_start,
            'festival_end' => $festival->festival_end,
            'results_at' => $festival->results_at,
        ]);
    }

    public function rules()
    {
        $festival = FestivalEdition::where('active', true)->first();

        if (!$festival) {
            return response()->json([], 404);
        }

        $rule = \App\Models\FestivalRule::where('festival_edition_id', $festival->id)->first();

        if (!$rule) {
            return response()->json(null, 404);
        }

        return response()->json([
            'title'   => $rule->title,
            'content' => $rule->content,
        ]);
    }
}
