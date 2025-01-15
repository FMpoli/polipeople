<?php

use Illuminate\Support\Facades\Route;
use Detit\Polipeople\Http\Controllers\Api\MemberController;

Route::get('/polipeople/members/{member}', [MemberController::class, 'show'])
    ->name('api.polipeople.members.show');
