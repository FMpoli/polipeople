<?php

use Illuminate\Support\Facades\Route;
use Detit\Polipeople\Http\Controllers\TeamController;
use Detit\Polipeople\Http\Controllers\MemberController;

// Route per il plugin standalone (usate solo quando il tema non è attivo)
Route::prefix('people')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/{slug}', [TeamController::class, 'show'])->name('teams.show');
});

