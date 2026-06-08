<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function store(Request $request)
    {
        if (!hash_equals(config('services.weather.cron_token'), $request->query('key', ''))) {
            return response('Unauthorized', 403);
        }

        $data = $request->validate([
            'temp'     => 'required|numeric',
            'humidity' => 'required|numeric',
            'pressure' => 'required|numeric',
            'wind'     => 'required|numeric',
            'rain'     => 'required|numeric',
        ]);

        WeatherReading::create([...$data, 'recorded_at' => time()]);

        // zostaw tylko ostatnie 288 wpisów (24h)
        WeatherReading::orderByDesc('id')
            ->skip(288)->take(PHP_INT_MAX)
            ->delete();

        return response()->noContent();
    }

    public function history()
    {
        return WeatherReading::where('recorded_at', '>=', now()->subDay()->timestamp)
            ->orderBy('recorded_at')
            ->get()
            ->map(fn($r) => [
                'time'     => $r->recorded_at,
                'temp'     => $r->temp,
                'humidity' => $r->humidity,
                'pressure' => $r->pressure,
                'wind'     => $r->wind,
                'rain'     => $r->rain,
            ]);
    }
}
