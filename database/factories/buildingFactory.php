<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition()
    {
        return [
            'building_th' => $this->faker->unique()->word,
            'building_en' => $this->faker->unique()->word,
            'building_image' => $this->faker->imageUrl(), 
        ];
    }
}
