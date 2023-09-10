<?php

namespace Database\Factories;

use App\Models\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\SaleStatues;
use App\Models\Customer;
use App\Models\Warehouse;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $warehouse = Warehouse::first();
        if (!$warehouse) {
            $warehouse = Warehouse::factory()->create();
        }
        return [
            'GrandTotal' => $this->faker->randomDigitNotNull,
            'TaxNet' => $this->faker->randomDigitNotNull,
            'the_date' => $this->faker->date('Y-m-d'),
            'discount' => $this->faker->randomDigitNotNull,
            'notes' => fake()->name(),
            'shipping' => $this->faker->randomDigitNotNull,
            'status_id' => SaleStatues::pluck('id')->random(),
            'customer_id' => Customer::pluck('id')->random(),
            'warehouse_id' => Warehouse::pluck('id')->random(),
            'tax_rate' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
