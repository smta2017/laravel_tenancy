<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;

class InventoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Inventory::class;

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
            'purchase_id' => Purchase::pluck('id')->random(),
            'product_id' => Product::pluck('id')->random(),
            'supplier_id' => Supplier::pluck('id')->random(),
            'warehouse_id' => Warehouse::pluck('id')->random(),
            'quantity' => $this->faker->randomDigitNotNull,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
