<?php

namespace Database\Factories;

use App\Models\ContractBand;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Contract;
use App\Models\Band;

class ContractBandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContractBand::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $band = Band::first();
        if (!$band) {
            $band = Band::factory()->create();
        }
        
        $contract = Contract::first();
        if (!$contract) {
            $contract = Contract::factory()->create();
        }

        return [
            'contract_id' => $contract->id,
            'band_id' => $band->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
