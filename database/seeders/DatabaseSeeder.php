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
            PermissionTableSeeder::class,
            ModuleTableSeeder::class,
            MenuTableSeeder::class,
            RoleTableSeeder::class,
            UserTableSeeder::class,
            StudentTableSeeder::class,
            AttendanceStatusTableSeeder::class,
            // StudentAttendanceTableSeeder::class,
            ExamTableSeeder::class,
            ExamClassTableSeeder::class,
            ExamScheduleTableSeeder::class,
            GradeTableSeeder::class
        ]);
    }
}
