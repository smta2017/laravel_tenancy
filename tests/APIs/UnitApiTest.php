<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Unit;

class UnitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_unit()
    {
        $unit = Unit::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/units', $unit
        );

        $this->assertApiResponse($unit);
    }

    /**
     * @test
     */
    public function test_read_unit()
    {
        $unit = Unit::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/units/'.$unit->id
        );

        $this->assertApiResponse($unit->toArray());
    }

    /**
     * @test
     */
    public function test_update_unit()
    {
        $unit = Unit::factory()->create();
        $editedUnit = Unit::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/units/'.$unit->id,
            $editedUnit
        );

        $this->assertApiResponse($editedUnit);
    }

    /**
     * @test
     */
    public function test_delete_unit()
    {
        $unit = Unit::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/units/'.$unit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/units/'.$unit->id
        );

        $this->response->assertStatus(404);
    }
}
