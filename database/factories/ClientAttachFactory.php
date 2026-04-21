<?php

namespace Database\Factories;

use App\Models\ClientAttach;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Client;
use App\Models\Attach;

class ClientAttachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientAttach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $attach = Attach::first();
        if (!$attach) {
            $attach = Attach::factory()->create();
        }

        return [
            'id' => $this->faker->word,
            'client_id' => $this->faker->word,
            'attach_id' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
