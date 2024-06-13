<?php

namespace Database\Factories;
use App\Models\Applicant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    protected $model = Applicant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_number' => $this->faker->unique()->numerify('ID####'),
            'id_card' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->name,
            'degree' => $this->faker->word,
            'position' => $this->faker->jobTitle,
        ];
    }
}
