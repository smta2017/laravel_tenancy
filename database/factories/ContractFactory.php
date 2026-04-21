<?php

namespace Database\Factories;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;

class ContractFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contract::class;

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

        return [
            'name' => $this->faker->word,
            'amount' => $this->faker->randomDigitNotNull,
            'subject' => $this->faker->word,
            'location' => $this->faker->word,
            'created_by' => $user->id,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
