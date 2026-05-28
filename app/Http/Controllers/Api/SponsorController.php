<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('active', true)
            ->orderBy('order')
            ->get();

        return response()->json(
            $sponsors->map(function ($sponsor) {
                return [
                    'id' => $sponsor->id,

                    'name' => $sponsor->name,

                    'logo' => $sponsor->logo
                        ? asset('storage/' . $sponsor->logo)
                        : null,

                    'url' => $sponsor->url,
                ];
            })
        );
    }
}