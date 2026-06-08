<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeatherReading;

class WeatherController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('weather store called', [
            'key_match' => hash_equals(config('services.weather.cron_token'), $request->query('key', '')),
            'data' => $request->all()
        ]);
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

        try {
            WeatherReading::create([...$data, 'recorded_at' => time()]);
            \Log::info('weather saved');
        } catch (\Exception $e) {
            \Log::error('weather save error: ' . $e->getMessage());
        }

        $oldest = WeatherReading::orderByDesc('id')->skip(12000)->value('id');
        if ($oldest) {
            WeatherReading::where('id', '<=', $oldest)->delete();
        }

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
