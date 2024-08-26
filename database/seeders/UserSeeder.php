<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	public function run() {
		if (User::query()->doesntExist()) {
			User::query()->create([
				'name' => 'User',
				'email' => 'user@example.com',
				'password' => bcrypt('password'),
			]);
		}
	}
}
