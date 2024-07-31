<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function maxYear()
    {
        $datetime = Carbon::now()->toDateTimeString();
        return date('Y');
    }

    //in the future this block functions must be read value of parameter table
    public function year()
    {
        return $this->maxYear();
    }

    public function emptyCartonClass()
    {
        return 1;
    }

    public function emptyPlasticClass()
    {
        return 26;
    }

    public function old_age_for_year()
    {
        return $this->maxYear() - 17;
    }
    //end parameteres function
}
