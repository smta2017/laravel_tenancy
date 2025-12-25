<?php

namespace Database\Factories;

use App\Models\TheCase;
use Illuminate\Database\Eloquent\Factories\Factory;


class TheCaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TheCase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' =>  $this->faker->word,
            'code' =>  $this->faker->word,
            'case_number' =>  $this->faker->word,
            'type' =>  $this->faker->word,
            'status' => $this->faker->randomDigitNotNull,
            'subject' =>  $this->faker->word,
            'court' =>  $this->faker->word
        ];
    }
}
