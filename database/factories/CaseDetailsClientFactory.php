<?php

namespace Database\Factories;

use App\Models\CaseDetailsClient;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\CaseDetails;
use App\Models\Client;
use App\Models\AttributeOpponent;

class CaseDetailsClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseDetailsClient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $attributeOpponent = AttributeOpponent::first();
        if (!$attributeOpponent) {
            $attributeOpponent = AttributeOpponent::factory()->create();
        }

        $client = Client::first();
        if (!$client) {
            $client = Client::factory()->create();
        }

        $caseDetails = CaseDetails::first();
        if (!$caseDetails) {
            $caseDetails = CaseDetails::factory()->create();
        }

        return [
            'case_details_id' => $caseDetails->id,
            'client_id' => $client->id,
            'attribute_opponent_id' => $attributeOpponent->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
