<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Yes'],
            ['name' => 'No'],
            ['name' => 'Active'],
            ['name' => 'Inactive'],            
            ['name' => 'Expired'],
            
        ];

        DB::table('statuses')->insert($statuses);
    }
}
