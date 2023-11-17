<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Owner
        DB::table('users')->insert([
            'name' => 'Owner',
            'position' => 'owner',
            'username' => 'owner',
            'password' => bcrypt('owner'),
            'created_at' => '2021-10-22 17:30:00',
            'updated_at' => '2021-10-22 17:30:00',
        ]);
    }
}
