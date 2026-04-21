<?php

namespace Database\Factories;

use App\Models\LitigationAuthority;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\LitigationAuthorityType;

class LitigationAuthorityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LitigationAuthority::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $litigationAuthorityType = LitigationAuthorityType::first();
        if (!$litigationAuthorityType) {
            $litigationAuthorityType = LitigationAuthorityType::factory()->create();
        }

        return [
            'name' => $this->faker->word,
            'type' => $litigationAuthorityType->id,
            'location' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
