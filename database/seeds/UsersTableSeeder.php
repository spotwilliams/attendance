<?php
namespace Cat\Database\Seeds;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\Illuminate\Foundation\Auth\User::create([
			'name'           => 'Admin',
			'email'          => 'admin@admin.com',
			'id_base'          => 2,
			'password'       => bcrypt('123456'),
			'remember_token' => str_random(10),
		]);
	}
}
