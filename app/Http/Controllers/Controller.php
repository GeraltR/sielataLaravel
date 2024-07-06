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

    public function MaxYear()
    {
        $datetime = Carbon::now()->toDateTimeString();
        return date('Y');
    }

    //in the future this function must be read value of parameter table
    public function Year()
    {
        return $this->MaxYear();
    }
}
