<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Category;
use App\Models\Status;
use App\Models\Brand;
use App\Models\Unit;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $unit = Unit::first();
        if (!$unit) {
            $unit = Unit::factory()->create();
        }

        return [
            'name' => fake()->name(),
            'code' => fake()->name(),
            'category_id' => Category::pluck('id')->random(),
            'status_id' => Status::pluck('id')->random(),
            'brand_id' => Brand::pluck('id')->random(),
            'tax' => $this->faker->randomDigitNotNull,
            'tax_type' => $this->faker->randomElement(['inc']),
            'description' => fake()->name(),
            'type' => $this->faker->randomElement(['standerd']),
            'cost' => $this->faker->randomDigitNotNull,
            'price' => $this->faker->randomDigitNotNull,
            'unit_id' => Unit::pluck('id')->random(),
            'sale_unit_id' => Unit::pluck('id')->random(),
            'purchase_unit_id' => Unit::pluck('id')->random(),
            'stok_alert' => $this->faker->randomDigitNotNull,
            'has_serial' => $this->faker->boolean,
            'not_for_sale' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
