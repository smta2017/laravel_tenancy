<?php

namespace Database\Factories;

use App\Models\LitigationLevel;
use Illuminate\Database\Eloquent\Factories\Factory;


class LitigationLevelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LitigationLevel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'name' => $this->faker->word,
            'color' => $this->faker->hexColor,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
