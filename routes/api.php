<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::withoutMiddleware(['auth:sanctum'])
	->prefix('auth')
	->group(function () {
		Route::post('login', [AuthController::class, 'login']);
	});

Route::get('files/{file}', [FileController::class, 'show']);
Route::post('files/{file}/generate', [FileController::class, 'runFileGeneration']);