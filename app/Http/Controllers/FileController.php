<?php

namespace App\Http\Controllers;

use App\Helpers\Message;
use App\Jobs\GenerateFileJob;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller {
	public function runFileGeneration(): JsonResponse {
		/** @var User $user */
		$user = Auth::user();

		GenerateFileJob::dispatch($user);

		return $this->respond(['message' => Message::FILE_GENERATION_STARTED]);
	}

	public function show(File $file): JsonResponse {
		return $this->respond($file);
	}
}
