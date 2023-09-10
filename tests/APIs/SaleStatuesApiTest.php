<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SaleStatues;

class SaleStatuesApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/sale-statues', $saleStatues
        );

        $this->assertApiResponse($saleStatues);
    }

    /**
     * @test
     */
    public function test_read_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/sale-statues/'.$saleStatues->id
        );

        $this->assertApiResponse($saleStatues->toArray());
    }

    /**
     * @test
     */
    public function test_update_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();
        $editedSaleStatues = SaleStatues::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/sale-statues/'.$saleStatues->id,
            $editedSaleStatues
        );

        $this->assertApiResponse($editedSaleStatues);
    }

    /**
     * @test
     */
    public function test_delete_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/sale-statues/'.$saleStatues->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/sale-statues/'.$saleStatues->id
        );

        $this->response->assertStatus(404);
    }
}
