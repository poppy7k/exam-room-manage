<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Building;
use App\Models\ExamRoomInformation;
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
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
        // Building::factory(10)->create();
        // ExamRoomInformation::factory(20)->create();

        $this->call([
            BuildingSeeder::class,
            ExamRoomInfomationSeeder::class,
        ]);
    }
}
