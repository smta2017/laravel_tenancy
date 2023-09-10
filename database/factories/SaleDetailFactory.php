<?php

namespace Database\Factories;

use App\Models\SaleDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Unit;

class SaleDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SaleDetail::class;

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

            'sale_id' => Sale::pluck('id')->random(),
            'name' => fake()->name(),
            'discountNet' => $this->faker->randomDigitNotNull,
            'discount_Method' => $this->faker->randomDigitNotNull,
            'discount' => $this->faker->randomDigitNotNull,
            'net_cost' => $this->faker->randomDigitNotNull,
            'unit_cost' => $this->faker->randomDigitNotNull,
            'code' => fake()->name(),
            'del' => $this->faker->randomDigitNotNull,
            'no_unit' => $this->faker->randomDigitNotNull,
            'product_id' => Product::pluck('id')->random(),
            'purchase_unit_id' => Unit::pluck('id')->random(),
            'quantity' => $this->faker->randomDigitNotNull,
            'stock' => $this->faker->randomDigitNotNull,
            'subtotal' => $this->faker->randomDigitNotNull,
            'tax_type' => $this->faker->randomElement(['inc']),
            'tax_percent' => $this->faker->randomDigitNotNull,
            'taxe' => $this->faker->randomDigitNotNull,
            'unitPurchase' => fake()->name(),
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
