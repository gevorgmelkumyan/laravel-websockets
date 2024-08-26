<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
	public function login(LoginRequest $request): JsonResponse {
		$credentials = $request->only('email', 'password');

		if (!Auth::attempt($credentials)) {
			return response()->json(['message' => 'Unauthorized'], 401);
		}

		$user = Auth::user();
		$token = $user->createToken('auth_token')->plainTextToken;

		return response()->json(compact('user', 'token'));
	}
}
