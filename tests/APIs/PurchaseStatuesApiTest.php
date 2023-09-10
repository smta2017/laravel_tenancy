<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PurchaseStatues;

class PurchaseStatuesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/purchase-statues', $purchaseStatues
        );

        $this->assertApiResponse($purchaseStatues);
    }

    /**
     * @test
     */
    public function test_read_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/purchase-statues/'.$purchaseStatues->id
        );

        $this->assertApiResponse($purchaseStatues->toArray());
    }

    /**
     * @test
     */
    public function test_update_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();
        $editedPurchaseStatues = PurchaseStatues::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/purchase-statues/'.$purchaseStatues->id,
            $editedPurchaseStatues
        );

        $this->assertApiResponse($editedPurchaseStatues);
    }

    /**
     * @test
     */
    public function test_delete_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/purchase-statues/'.$purchaseStatues->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/purchase-statues/'.$purchaseStatues->id
        );

        $this->response->assertStatus(404);
    }
}
