<?php

namespace App\Jobs;

use App\Events\FileUpdatedEvent;
use App\Models\File;
use App\Models\User;
use Faker\Factory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateFileJob implements ShouldQueue {
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/** @var User $user */
	protected $user;
	/** @var File $file */
	protected $file;

	public function __construct(User $user) {
		$this->user = $user;
	}

	public function handle() {
		$total = rand(100000, 1000000);
		$generated = 0;
		$faker = Factory::create();

		$name = 'file_' . time();
		$path = $this->user->id . '_' . $name . '.csv';

		$this->file = $this->user->files()->create([
			'name' => $name,
			'path' => $path,
			'total' => $total,
		]);

		event(new FileUpdatedEvent($this->user->id, $this->file));

		$header = ['id', 'name', 'email', 'date'];

		$fp = fopen(storage_path('app/' . $this->file->path), 'w');
		fputcsv($fp, $header);

		while ($generated < $total) {
			$generated++;
			$data = [
				$faker->uuid(),
				$faker->name(),
				$faker->email(),
				$faker->date(),
			];
			fputcsv($fp, $data);

			if ($generated === 1) {
				$this->file->update([
					'status' => File::STATUS_GENERATING,
				]);
			}

			if ($generated % 1200 === 0) {
				event(new FileUpdatedEvent($this->user->id, $this->file));
			}
		}

		fclose($fp);

		$this->file->update([
			'status' => File::STATUS_GENERATED,
		]);

		event(new FileUpdatedEvent($this->user->id, $this->file));
	}
}
