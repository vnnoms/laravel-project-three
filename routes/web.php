<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivityController::class, 'index']);
Route::get('/activities/{activity}', [ActivityController::class, 'show'])->name('activities.show');
