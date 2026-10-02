<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivityController::class, 'index']);

Route::get('activities/trash', [ActivityController::class, 'trash'])->name('activities.trash');
Route::patch('activities/{id}/restore', [ActivityController::class, 'restore'])->name('activities.restore');
Route::patch('activities/{activity}/publish', [ActivityController::class, 'publish'])->name('activities.publish');
Route::patch('activities/{activity}/complete', [ActivityController::class, 'complete'])->name('activities.complete');

Route::resource('activities', ActivityController::class);

Route::resource('categories', CategoryController::class)->only(['index', 'destroy']);