<?php

use Illuminate\Support\Facades\Route;
use Detit\Polipeople\Http\Controllers\MemberController;
use Detit\Polipeople\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Log;
Log::info('Routes for Polipeople package have been loaded.');
Route::group(['middleware' => ['web']], function () {
    Route::get('/people', [TeamController::class, 'index'])->name('team.index');
    Route::get('/people/{slug}', [MemberController::class, 'show'])->name('people.show');
    Route::get('/people/c/{slug?}', [TeamController::class, 'index'])->name('team.show');
});
