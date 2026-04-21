<?php

namespace Tests\Repositories;

use App\Models\ContractBand;
use App\Repositories\ContractBandRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ContractBandRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ContractBandRepository $contractBandRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->contractBandRepo = app(ContractBandRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_contract_band()
    {
        $contractBand = ContractBand::factory()->make()->toArray();

        $createdContractBand = $this->contractBandRepo->create($contractBand);

        $createdContractBand = $createdContractBand->toArray();
        $this->assertArrayHasKey('id', $createdContractBand);
        $this->assertNotNull($createdContractBand['id'], 'Created ContractBand must have id specified');
        $this->assertNotNull(ContractBand::find($createdContractBand['id']), 'ContractBand with given id must be in DB');
        $this->assertModelData($contractBand, $createdContractBand);
    }

    /**
     * @test read
     */
    public function test_read_contract_band()
    {
        $contractBand = ContractBand::factory()->create();

        $dbContractBand = $this->contractBandRepo->find($contractBand->id);

        $dbContractBand = $dbContractBand->toArray();
        $this->assertModelData($contractBand->toArray(), $dbContractBand);
    }

    /**
     * @test update
     */
    public function test_update_contract_band()
    {
        $contractBand = ContractBand::factory()->create();
        $fakeContractBand = ContractBand::factory()->make()->toArray();

        $updatedContractBand = $this->contractBandRepo->update($fakeContractBand, $contractBand->id);

        $this->assertModelData($fakeContractBand, $updatedContractBand->toArray());
        $dbContractBand = $this->contractBandRepo->find($contractBand->id);
        $this->assertModelData($fakeContractBand, $dbContractBand->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_contract_band()
    {
        $contractBand = ContractBand::factory()->create();

        $resp = $this->contractBandRepo->delete($contractBand->id);

        $this->assertTrue($resp);
        $this->assertNull(ContractBand::find($contractBand->id), 'ContractBand should not exist in DB');
    }
}
