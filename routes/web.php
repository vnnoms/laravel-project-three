<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;                                                                                                                                            

Route::get('/', [ActivityController::class, 'index']);
Route::resource('activities', ActivityController::class);
Route::resource('categories', CategoryController::class)->only(['index', 'destroy']);