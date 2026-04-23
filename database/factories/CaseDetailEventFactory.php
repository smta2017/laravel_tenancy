<?php

namespace Database\Factories;

use App\Models\CaseDetailEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\CaseDetails;
use App\Models\CaseType;
use App\Models\CaseState;
use App\Models\User;
class CaseDetailEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseDetailEvent::class;

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

        $caseDetails = CaseDetails::first();
        // if (!$caseDetails) {
        //     $caseDetails = CaseDetails::factory()->create();
        // }

        // $caseDetailEvent = CaseDetailEvent::first();
        // if (!$caseDetailEvent) {
        //     $caseDetailEvent = CaseDetailEvent::factory()->create();
        // }

        $caseType = CaseType::first();
        // if (!$caseType) {
        //     $caseType = CaseType::factory()->create();
        // }

        $caseState = CaseState::first();
        // if (!$caseState) {
        //     $caseState = CaseState::factory()->create();
        // }

        return [
            'case_details_id' => $caseDetails->id,
            'subject' => $this->faker->word,
            'notes' => $this->faker->word,
            'type_id' => $caseType->id,
            'status_id' => $caseState->id,
            'created_by' => $user->id,
            'assigned_to' => $user->id,
            'closed_by' => $user->id,
            'is_private' => $this->faker->boolean,
            'client_access' => $this->faker->boolean,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
