<?php

declare(strict_types=1);

use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/users', [UsersController::class, 'register'])->name('users.store');
