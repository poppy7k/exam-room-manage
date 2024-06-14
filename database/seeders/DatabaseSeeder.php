<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\User;
use App\Models\Building;
use App\Models\ExamRoomInformation;
use App\Models\Staff;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Building::factory(10)->create();
        // ExamRoomInformation::factory(20)->create();
        // Applicant::factory(5)->create();
        // Staff::factory(5)->create();
        // Clear the building_images directory
        Storage::disk('public')->deleteDirectory('building_images');
        Storage::disk('public')->makeDirectory('building_images/default');

        // Copy default images back to the directory
        $defaultImagePath = base_path('default-images/default-building-image.jpg');
        if (file_exists($defaultImagePath)) {
            Storage::disk('public')->put('building_images/default/default-building-image.jpg', file_get_contents($defaultImagePath));
        } else {
            $this->command->error('Default image not found at ' . $defaultImagePath);
        }

        $this->call([
            BuildingSeeder::class,
            ExamRoomInfomationSeeder::class,
            ApplicantSeeder::class,
            StaffSeeder::class,
        ]);
    }
}
