<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use App\Models\FestivalEdition;
use App\Models\Category;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function maxYear()
    {
        try {
            $maxYear = Carbon::parse(FestivalEdition::max('registration_start'))->year;
        } catch (\Throwable $th) {
            $maxYear = Carbon::now()->year;
        }

        return $maxYear;
    }

    //in the future this block functions must be read value of parameter table
    public function year()
    {
        try {
            $maxYear = Carbon::parse(FestivalEdition::where('active', '1')
                ->max('registration_start'))->year;
        } catch (\Throwable $th) {
            $maxYear = Carbon::now()->year;
        }
        return $maxYear;
    }

    public function emptyCartonClass()
    {
        try {
            return Category::where('symbol', '000')->first()->Idkat;
        } catch (\Throwable $th) {
            return 1;
        }
    }

    public function emptyPlasticClass()
    {
        try {
            return Category::where('symbol', '0000')->first()->Idkat;
        } catch (\Throwable $th) {
            return 26;
        }
    }

    public function old_age_for_year()
    {
        return $this->maxYear() - 17;
    }
    //end parameteres function
}