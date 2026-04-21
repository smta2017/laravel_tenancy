<?php

namespace Database\Factories;

use App\Models\CaseDetails;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\TheCase;
use App\Models\LitigationLevel;
use App\Models\LitigationAuthority;
use App\Models\User;

class CaseDetailsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CaseDetails::class;

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

        $litigationLevel = LitigationLevel::first();
        if (!$litigationLevel) {
            $litigationLevel = LitigationLevel::factory()->create();
        }

        $litigationAuthority = LitigationAuthority::first();
        if (!$litigationAuthority) {
            $litigationAuthority = LitigationAuthority::factory()->create();
        }

        $theCase = TheCase::first();
        if (!$theCase) {
            $theCase = TheCase::factory()->create();
        }


        return [
            'case_id' => $theCase->id,
            'litigation_level_id' => $litigationLevel->id,
            'case_number' => $this->faker->word,
            'circle' => $this->faker->word,
            'floor' => $this->faker->word,
            'hall' => $this->faker->word,
            'secretary' => $this->faker->word,
            'litigation_authority_id' => $litigationAuthority->id,
            'gedge' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'created_by' => $user->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
