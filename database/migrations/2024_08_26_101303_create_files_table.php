<?php

use App\Models\File;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration {
	public function up() {
		Schema::create('files', function (Blueprint $table) {
			$table->id();
			$table->foreignIdFor(User::class)
				->constrained()
				->cascadeOnUpdate()
				->cascadeOnDelete();
			$table->string('name');
			$table->string('path')->nullable();
			$table->string('status')->default(File::STATUS_NEW);
			$table->unsignedInteger('total');
			$table->unsignedInteger('generated')->default(0);

			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('files');
	}
}
