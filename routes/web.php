<?php

use Illuminate\Support\Facades\Route;
Route::get('/xdebug', function () { xdebug_info(); });
Route::get('/phpinfo', function () { phpinfo(); });
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
