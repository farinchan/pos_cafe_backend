<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Fajri Rinaldi Chan',
            'username' => 'fajri_chan',
             'password' => bcrypt('password'),
             'role' => 'owner',
        ]);

        Business::create([
            'name' => 'Cafe Ceria',
            'address' => 'Jl. Jala Raya No.3 Blok X',
            'city' => 'Medan',
            'state' => 'Sumatera Utara',
            'zip' => '20251',
            'country' => 'Indonesia',
            'owner_id' => 1,
        ]);

    }
}
