<?php

namespace Database\Factories;

use App\Models\ExamRoomInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExamRoomInformation>
 */
class ExamRoomInformationFactory extends Factory
{
    protected $model = ExamRoomInformation::class;

    public function definition()
    {
        return [
            // 'orders' => $this->faker->unique()->randomNumber(),
            'building_name' => $this->faker->word,
            'building_code' => $this->faker->unique()->word,
            'floor' => $this->faker->numberBetween(1, 10),
            'total_seat' => $this->faker->numberBetween(10, 100),
            'valid_seat' => $this->faker->numberBetween(5, 50),
        ];
    }
}

