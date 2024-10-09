<?php

use Illuminate\Support\Facades\Route;
use Detit\Polipeople\Http\Controllers\MemberController;
use Detit\Polipeople\Http\Controllers\TeamController;

Route::group(['middleware' => ['web']], function () {
    // Route::get(__('polipeople::messages.team'), [TeamController::class, 'index'])->name('team.index');
    Route::get('/people', [TeamController::class, 'index'])->name('team.index');
    Route::get('/people/{slug}', [MemberController::class, 'show'])->name('people.show');
    Route::get('/people/c/{slug?}', [TeamController::class, 'index'])->name('team.show');
});

