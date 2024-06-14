<?php

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use App\Models\Building;

// class BuildingSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */
//     public function run(): void
//     {
//         $building = new Building();
//         $building->building_th = "ศูนย์เรียนรวม 1";
//         $building->building_en = "Lecture Hall 1";
//         $building->building_image = "Lecture Hall 1.jpg";
//         $building->save();

//         $building = new Building();
//         $building->building_th = "ศูนย์เรียนรวม 3";
//         $building->building_en = "Lecture Hall 3";
//         $building->building_image = "Lecture Hall 3.jpg";
//         $building->save();

//         $building = new Building();
//         $building->building_th = "ศูนย์เรียนรวม 4";
//         $building->building_en = "Lecture Hall 4";
//         $building->building_image = "Lecture Hall 4.jpg";
//         $building->save();

//         $building = new Building();
//         $building->building_th = "เทพศาสตร์สถิตย์";
//         $building->building_en = "Thep Sat Sathit Building";
//         $building->building_image = "Thep Sat Sathit Building.jpg";
//         $building->save();

//         $building = new Building();
//         $building->building_th = "ศูนย์กิจกรรมนิสิต";
//         $building->building_en = "Student Activity Center";
//         $building->building_image = NULL; 
//         $building->save(); 

//         $building = new Building();
//         $building->building_th = "สารนิเทศ 50 ปี";
//         $building->building_en = "Kasetsart Golden Jubilee Administrative and Information Center";
//         $building->building_image = "Kasetsart Golden Jubilee Administrative and Information Center.jpg";
//         $building->save();
//     }
// }
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use Illuminate\Support\Facades\Storage;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            [
                'building_th' => 'ศูนย์เรียนรวม 1',
                'building_en' => 'Lecture Hall 1',
                'building_image' => 'Lecture Hall 1.jpg',
            ],
            [
                'building_th' => 'ศูนย์เรียนรวม 3',
                'building_en' => 'Lecture Hall 3',
                'building_image' => 'Lecture Hall 3.jpg',
            ],
            [
                'building_th' => 'ศูนย์เรียนรวม 4',
                'building_en' => 'Lecture Hall 4',
                'building_image' => 'Lecture Hall 4.jpg',
            ],
            [
                'building_th' => 'เทพศาสตร์สถิตย์',
                'building_en' => 'Thep Sat Sathit Building',
                'building_image' => 'Thep Sat Sathit Building.jpg',
            ],
            [
                'building_th' => 'ศูนย์กิจกรรมนิสิต',
                'building_en' => 'Student Activity Center',
                'building_image' => null,
            ],
            [
                'building_th' => 'สารนิเทศ 50 ปี',
                'building_en' => 'Kasetsart Golden Jubilee Administrative and Information Center',
                'building_image' => 'Kasetsart Golden Jubilee Administrative and Information Center.jpg',
            ],
        ];

        foreach ($buildings as $buildingData) {
            if ($buildingData['building_image']) {
                $sourcePath = base_path('default-images/' . $buildingData['building_image']);
                if (file_exists($sourcePath)) {
                    Storage::disk('public')->put('building_images/' . $buildingData['building_image'], file_get_contents($sourcePath));
                } else {
                    $this->command->warn('Image not found: ' . $buildingData['building_image']);
                }
            }

            $building = new Building();
            $building->building_th = $buildingData['building_th'];
            $building->building_en = $buildingData['building_en'];
            $building->building_image = $buildingData['building_image'];
            $building->save();
        }
    }
}
