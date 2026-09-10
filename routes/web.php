<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcknowledgementPrintController;

Route::get('/podziekowania/print', [AcknowledgementPrintController::class, 'showBatch'])
    ->name('acknowledgements.print.batch');

Route::get('/podziekowania/{acknowledgement}/print', [AcknowledgementPrintController::class, 'show'])
    ->whereNumber('acknowledgement')
    ->name('acknowledgements.print');

Route::get('/xdebug', function () { xdebug_info(); });
Route::get('/phpinfo', function () { phpinfo(); });
Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
