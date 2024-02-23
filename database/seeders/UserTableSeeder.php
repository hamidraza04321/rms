<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserDetail;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
        	'name' => 'Super Admin',
        	'email' => 'rms@gmail.com',
            'username' => 'superadmin',
        	'password' => bcrypt('123456')
        ]);

        UserDetail::create([
            'user_id' => $user->id,
            'phone_no' => '+92 3043035679',
            'designation' => 'Administrator',
            'address' => '8888 Cummings Vista Apt. 101, Susanbury, NY 95473',
            'age' => '18',
            'date_of_birth' => date('Y-m-d'),
            'location' => 'Karachi, Pakistan',
            'skills' => 'PHP, Laravel, jQuery, AJAX and more.'
        ]);

        $user->assignRole('Super Admin');
    }
}
