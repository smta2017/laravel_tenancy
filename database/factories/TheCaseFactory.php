<?php

namespace Database\Factories;

use App\Models\TheCase;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\CaseType;
use App\Models\CaseState;
use App\Models\Contract;
use App\Models\User;

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

        $user = User::first();
        if (!$user) {
            $user = User::factory()->create();
        }

        $caseType = CaseType::first();
        if (!$caseType) {
            $caseType = CaseType::factory()->create();
        }

        $caseState = CaseState::first();
        if (!$caseState) {
            $caseState = CaseState::factory()->create();
        }

        $contract = Contract::first();
        if (!$contract) {
            $contract = Contract::factory()->create();
        }
        $rr = "jjj";
        return [
            'AutoNumber' => $this->faker->word,
            'code' => $this->faker->word,
            'case_number' => $this->faker->word,
            'subject' => $this->faker->word,
            'type_id' => $caseType->id,
            'status_id' => $caseState->id,
            'contract_id' => $contract->id,
            'created_by' => $user->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
