<?php

namespace Tests\Repositories;

use App\Models\SaleDetail;
use App\Repositories\SaleDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SaleDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SaleDetailRepository $saleDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->saleDetailRepo = app(SaleDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->make()->toArray();

        $createdSaleDetail = $this->saleDetailRepo->create($saleDetail);

        $createdSaleDetail = $createdSaleDetail->toArray();
        $this->assertArrayHasKey('id', $createdSaleDetail);
        $this->assertNotNull($createdSaleDetail['id'], 'Created SaleDetail must have id specified');
        $this->assertNotNull(SaleDetail::find($createdSaleDetail['id']), 'SaleDetail with given id must be in DB');
        $this->assertModelData($saleDetail, $createdSaleDetail);
    }

    /**
     * @test read
     */
    public function test_read_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();

        $dbSaleDetail = $this->saleDetailRepo->find($saleDetail->id);

        $dbSaleDetail = $dbSaleDetail->toArray();
        $this->assertModelData($saleDetail->toArray(), $dbSaleDetail);
    }

    /**
     * @test update
     */
    public function test_update_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();
        $fakeSaleDetail = SaleDetail::factory()->make()->toArray();

        $updatedSaleDetail = $this->saleDetailRepo->update($fakeSaleDetail, $saleDetail->id);

        $this->assertModelData($fakeSaleDetail, $updatedSaleDetail->toArray());
        $dbSaleDetail = $this->saleDetailRepo->find($saleDetail->id);
        $this->assertModelData($fakeSaleDetail, $dbSaleDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sale_detail()
    {
        $saleDetail = SaleDetail::factory()->create();

        $resp = $this->saleDetailRepo->delete($saleDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(SaleDetail::find($saleDetail->id), 'SaleDetail should not exist in DB');
    }
}
