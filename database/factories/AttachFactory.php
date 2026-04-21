<?php

namespace Database\Factories;

use App\Models\Attach;
use Illuminate\Database\Eloquent\Factories\Factory;


class AttachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Attach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'id' => $this->faker->word,
            'name' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'type' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'path' => $this->faker->text($this->faker->numberBetween(5, 4096)),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
