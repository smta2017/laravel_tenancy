<?php

namespace Tests\Repositories;

use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SaleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected SaleRepository $saleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->saleRepo = app(SaleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_sale()
    {
        $sale = Sale::factory()->make()->toArray();

        $createdSale = $this->saleRepo->create($sale);

        $createdSale = $createdSale->toArray();
        $this->assertArrayHasKey('id', $createdSale);
        $this->assertNotNull($createdSale['id'], 'Created Sale must have id specified');
        $this->assertNotNull(Sale::find($createdSale['id']), 'Sale with given id must be in DB');
        $this->assertModelData($sale, $createdSale);
    }

    /**
     * @test read
     */
    public function test_read_sale()
    {
        $sale = Sale::factory()->create();

        $dbSale = $this->saleRepo->find($sale->id);

        $dbSale = $dbSale->toArray();
        $this->assertModelData($sale->toArray(), $dbSale);
    }

    /**
     * @test update
     */
    public function test_update_sale()
    {
        $sale = Sale::factory()->create();
        $fakeSale = Sale::factory()->make()->toArray();

        $updatedSale = $this->saleRepo->update($fakeSale, $sale->id);

        $this->assertModelData($fakeSale, $updatedSale->toArray());
        $dbSale = $this->saleRepo->find($sale->id);
        $this->assertModelData($fakeSale, $dbSale->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_sale()
    {
        $sale = Sale::factory()->create();

        $resp = $this->saleRepo->delete($sale->id);

        $this->assertTrue($resp);
        $this->assertNull(Sale::find($sale->id), 'Sale should not exist in DB');
    }
}
