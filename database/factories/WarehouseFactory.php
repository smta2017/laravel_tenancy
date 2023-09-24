<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;


class WarehouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Warehouse::class;
    private static $counter = 1;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $serialNumber = self::$counter++;

        return [
            'name' => 'Warehouse' . $serialNumber, // Use unique() to ensure unique numbers
            'phone' => $this->faker->numerify('0##########'),
            'country' => fake()->name(),
            'city' => fake()->name(),
            'email' => $this->faker->email,
            'zipcode' => fake()->name(),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
