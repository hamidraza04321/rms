<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Session;

class SessionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sessions = [
            [
                'name' => date('Y', strtotime("-2 year")) . '-' . date('Y', strtotime("-1 year")),
                'start_date' => date('Y', strtotime("-2 year")) . '-04-01',
                'end_date' => date('Y', strtotime("-1 year")) . '-03-31'
            ],
            [
                'name' => date('Y', strtotime("-1 year")) . '-' . date('Y'),
                'start_date' => date('Y', strtotime("-1 year")) . '-04-01',
                'end_date' => date('Y') . '-03-31'
            ],
            [
                'name' => date('Y') . '-' . date('Y', strtotime("+1 year")),
                'start_date' => date('Y') . '-04-01',
                'end_date' => date('Y', strtotime("+1 year")) . '-03-31'
            ]
        ];

        // TIMESTAMPS
        $data = [];
        foreach ($sessions as $value) {
            $data[] = array_merge($value, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Session::insert($data);
    }
}
