<?php

namespace Tests\Repositories;

use App\Models\SaleStatues;
use App\Repositories\SaleStatuesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SaleStatuesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SaleStatuesRepository $saleStatuesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->saleStatuesRepo = app(SaleStatuesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->make()->toArray();

        $createdSaleStatues = $this->saleStatuesRepo->create($saleStatues);

        $createdSaleStatues = $createdSaleStatues->toArray();
        $this->assertArrayHasKey('id', $createdSaleStatues);
        $this->assertNotNull($createdSaleStatues['id'], 'Created SaleStatues must have id specified');
        $this->assertNotNull(SaleStatues::find($createdSaleStatues['id']), 'SaleStatues with given id must be in DB');
        $this->assertModelData($saleStatues, $createdSaleStatues);
    }

    /**
     * @test read
     */
    public function test_read_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();

        $dbSaleStatues = $this->saleStatuesRepo->find($saleStatues->id);

        $dbSaleStatues = $dbSaleStatues->toArray();
        $this->assertModelData($saleStatues->toArray(), $dbSaleStatues);
    }

    /**
     * @test update
     */
    public function test_update_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();
        $fakeSaleStatues = SaleStatues::factory()->make()->toArray();

        $updatedSaleStatues = $this->saleStatuesRepo->update($fakeSaleStatues, $saleStatues->id);

        $this->assertModelData($fakeSaleStatues, $updatedSaleStatues->toArray());
        $dbSaleStatues = $this->saleStatuesRepo->find($saleStatues->id);
        $this->assertModelData($fakeSaleStatues, $dbSaleStatues->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sale_statues()
    {
        $saleStatues = SaleStatues::factory()->create();

        $resp = $this->saleStatuesRepo->delete($saleStatues->id);

        $this->assertTrue($resp);
        $this->assertNull(SaleStatues::find($saleStatues->id), 'SaleStatues should not exist in DB');
    }
}
