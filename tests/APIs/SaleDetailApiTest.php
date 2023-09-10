<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SaleDetail;

class SaleDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sale-details', $saleDetail
        );

        $this->assertApiResponse($saleDetail);
    }

    /**
     * @test
     */
    public function test_read_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/sale-details/'.$saleDetail->id
        );

        $this->assertApiResponse($saleDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();
        $editedSaleDetail = SaleDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sale-details/'.$saleDetail->id,
            $editedSaleDetail
        );

        $this->assertApiResponse($editedSaleDetail);
    }

    /**
     * @test
     */
    public function test_delete_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sale-details/'.$saleDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sale-details/'.$saleDetail->id
        );

        $this->response->assertStatus(404);
    }
}
