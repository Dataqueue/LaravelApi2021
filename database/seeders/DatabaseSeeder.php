<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'fname' => 'superadmin',
            'email' => 'superadmin@email.com',
            'password' => bcrypt("superadmin@123"),
            'role_id' => 1,
            'designation'=> 'Business Development Manager',
            'prefix'=>"Mr."
            ]);
        \App\Models\User::factory()->create([
            'fname' => 'admin',
            'email' => 'admin@email.com',
            'password' => bcrypt("admin@123"),
            'role_id' => 2,
            'designation'=> 'Business Development Manager',
            'prefix'=>"Mr."
            ]);
        \App\Models\User::factory()->create([
            'fname' => 'editor',
            'email' => 'editor@email.com',
            'password' => bcrypt("editor@123"),
            'role_id' => 3,
            'designation'=> 'Business Development Manager',
            'prefix'=>"Mr."
            ]);
        \App\Models\User::factory()->create([
            'fname' => 'guest',
            'email' => 'guest@email.com',
            'password' => bcrypt("guest@123"),
            'role_id' => 4,
            'designation'=> 'Business Development Manager',
            'prefix'=>"Mr."
            ]);

        \App\Models\Roles::create([
            'name' => 'SA',
        ]);
        \App\Models\Roles::create([
            'name' => 'ADMIN',
        ]);
        \App\Models\Roles::create([
            'name' => 'EDITOR',
        ]);
        \App\Models\Roles::create([
            'name' => 'GUEST',
        ]);
    }
}
