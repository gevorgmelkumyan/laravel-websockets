<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Route::middleware('cors')->group(function () {
	Broadcast::routes();

	Broadcast::channel('lw.{user}', function (User $user) {
		return true;
	});
});