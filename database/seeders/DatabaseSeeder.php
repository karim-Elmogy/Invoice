<?php

namespace Database\Seeders;

use CreateAdminUserSeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;


use PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call(PermissionTableSeeder::class);
        $this->call(CreateAdminUserSeeder::class);


    }
}
