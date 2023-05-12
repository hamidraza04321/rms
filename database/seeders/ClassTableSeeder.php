<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classes;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = collect([
            [ 'name' => 'Class I' ],
            [ 'name' => 'Class II' ],
            [ 'name' => 'Class III' ],
            [ 'name' => 'Class IV' ],
            [ 'name' => 'Class V' ],
            [ 'name' => 'Class VI' ],
            [ 'name' => 'Class VII' ],
            [ 'name' => 'Class VIII' ],
            [ 'name' => 'Class IX' ],
            [ 'name' => 'Class X' ]
        ]);

        $classes->each(function($class){
            Classes::create($class);
        });
    }
}
