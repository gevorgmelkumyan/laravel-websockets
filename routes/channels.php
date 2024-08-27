<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
	'middleware' => ['auth:sanctum'],
]);

Broadcast::channel('lw.{user}', function (User $user) {
	return true;
});