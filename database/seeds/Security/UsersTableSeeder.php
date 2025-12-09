<?php

namespace Cat\Database\Security;

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
        $user = User::create([
            'name'           => 'developer',
            'cuit'           => '1234567',
            'email'          => 'admin@remain-it.com',
            'password'       => bcrypt('remain14159'),
            'remember_token' => str_random(10),
        ]);
        
        $user->syncRoles(Role::findByName('Permisos full'));
        
    }
}
