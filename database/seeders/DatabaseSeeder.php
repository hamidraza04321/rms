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
            SessionTableSeeder::class,
            ClassTableSeeder::class,
            SectionTableSeeder::class,
            GroupTableSeeder::class,
            SubjectTableSeeder::class,
            ClassSectionTableSeeder::class,
            ClassGroupTableSeeder::class,
            ClassSubjectTableSeeder::class,
            RoleTableSeeder::class,
            PermissionTableSeeder::class,
            ModuleTableSeeder::class,
            MenuTableSeeder::class,
            UserTableSeeder::class,
            StudentTableSeeder::class
        ]);
    }
}
