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
        // \App\Models\User::factory(10)->create();

        \App\Models\MembershipPlan::create([
            'name' => 'Paket Basic',
            'durasi' => 1,
            'harga' => 50000,
            'status' => 'active'
        ]);

        \App\Models\MembershipPlan::create([
            'name' => 'Paket Middle',
            'durasi' => 3,
            'harga' => 130000,
            'status' => 'active'
        ]);

        \App\Models\MembershipPlan::create([
            'name' => 'Paket Advance',
            'durasi' => 6,
            'harga' => 250000,
            'status' => 'active'
        ]);
    }
}
