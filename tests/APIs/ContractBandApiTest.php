<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ContractBand;

class ContractBandApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_contract_band()
    {
        $contractBand = ContractBand::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/contract-bands', $contractBand
        );

        $this->assertApiResponse($contractBand);
    }

    /**
     * @test
     */
    public function test_read_contract_band()
    {
        $contractBand = ContractBand::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/contract-bands/'.$contractBand->id
        );

        $this->assertApiResponse($contractBand->toArray());
    }

    /**
     * @test
     */
    public function test_update_contract_band()
    {
        $contractBand = ContractBand::factory()->create();
        $editedContractBand = ContractBand::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/contract-bands/'.$contractBand->id,
            $editedContractBand
        );

        $this->assertApiResponse($editedContractBand);
    }

    /**
     * @test
     */
    public function test_delete_contract_band()
    {
        $contractBand = ContractBand::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/contract-bands/'.$contractBand->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/contract-bands/'.$contractBand->id
        );

        $this->response->assertStatus(404);
    }
}
