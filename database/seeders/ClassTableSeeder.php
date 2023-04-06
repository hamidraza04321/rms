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
        Classes::create([ 'name' => 'Class I' ]);
        Classes::create([ 'name' => 'Class II' ]);
        Classes::create([ 'name' => 'Class III' ]);
        Classes::create([ 'name' => 'Class IV' ]);
        Classes::create([ 'name' => 'Class V' ]);
        Classes::create([ 'name' => 'Class VI' ]);
        Classes::create([ 'name' => 'Class VII' ]);
        Classes::create([ 'name' => 'Class VIII' ]);
        Classes::create([ 'name' => 'Class IX' ]);
        Classes::create([ 'name' => 'Class X' ]);
    }
}
