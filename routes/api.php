<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/users/me', [UserController::class, 'me'])
    ->middleware('auth:sanctum');
    
Route::post('/users', [UserController::class, 'store']);
