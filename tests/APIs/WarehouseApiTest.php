<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Warehouse;

class WarehouseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_warehouse()
    {
        $warehouse = Warehouse::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/warehouses', $warehouse
        );

        $this->assertApiResponse($warehouse);
    }

    /**
     * @test
     */
    public function test_read_warehouse()
    {
        $warehouse = Warehouse::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/warehouses/'.$warehouse->id
        );

        $this->assertApiResponse($warehouse->toArray());
    }

    /**
     * @test
     */
    public function test_update_warehouse()
    {
        $warehouse = Warehouse::factory()->create();
        $editedWarehouse = Warehouse::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/warehouses/'.$warehouse->id,
            $editedWarehouse
        );

        $this->assertApiResponse($editedWarehouse);
    }

    /**
     * @test
     */
    public function test_delete_warehouse()
    {
        $warehouse = Warehouse::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/warehouses/'.$warehouse->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/warehouses/'.$warehouse->id
        );

        $this->response->assertStatus(404);
    }
}
