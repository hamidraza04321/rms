<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $this->call([
            ClassTableSeeder::class,
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            ModuleTableSeeder::class,
            MenuTableSeeder::class,
            UserTableSeeder::class
        ]);
    }
}
