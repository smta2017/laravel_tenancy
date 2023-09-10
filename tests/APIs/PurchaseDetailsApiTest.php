<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PurchaseDetails;

class PurchaseDetailsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/purchase-details', $purchaseDetails
        );

        $this->assertApiResponse($purchaseDetails);
    }

    /**
     * @test
     */
    public function test_read_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/purchase-details/'.$purchaseDetails->id
        );

        $this->assertApiResponse($purchaseDetails->toArray());
    }

    /**
     * @test
     */
    public function test_update_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();
        $editedPurchaseDetails = PurchaseDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/purchase-details/'.$purchaseDetails->id,
            $editedPurchaseDetails
        );

        $this->assertApiResponse($editedPurchaseDetails);
    }

    /**
     * @test
     */
    public function test_delete_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/purchase-details/'.$purchaseDetails->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/purchase-details/'.$purchaseDetails->id
        );

        $this->response->assertStatus(404);
    }
}
