<?php

namespace Database\Seeders\Security;

use Cat\Modules\Security\Models\Role;
use Cat\User;
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
        $faker = \Faker\Factory::create();

        $user = User::create([
            'name'           => $faker->name(),
            'cuit'           => '20' . $faker->unique()->numerify('########') . '0',
            'email'          => $faker->unique()->safeEmail(),
            'password'       => bcrypt('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
        
        $user->syncRoles(Role::findByName('Permisos full'));
        
    }
}
