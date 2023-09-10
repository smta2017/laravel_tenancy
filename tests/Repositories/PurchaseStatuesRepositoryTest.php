<?php

namespace Tests\Repositories;

use App\Models\PurchaseStatues;
use App\Repositories\PurchaseStatuesRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PurchaseStatuesRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected PurchaseStatuesRepository $purchaseStatuesRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->purchaseStatuesRepo = app(PurchaseStatuesRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->make()->toArray();

        $createdPurchaseStatues = $this->purchaseStatuesRepo->create($purchaseStatues);

        $createdPurchaseStatues = $createdPurchaseStatues->toArray();
        $this->assertArrayHasKey('id', $createdPurchaseStatues);
        $this->assertNotNull($createdPurchaseStatues['id'], 'Created PurchaseStatues must have id specified');
        $this->assertNotNull(PurchaseStatues::find($createdPurchaseStatues['id']), 'PurchaseStatues with given id must be in DB');
        $this->assertModelData($purchaseStatues, $createdPurchaseStatues);
    }

    /**
     * @test read
     */
    public function test_read_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();

        $dbPurchaseStatues = $this->purchaseStatuesRepo->find($purchaseStatues->id);

        $dbPurchaseStatues = $dbPurchaseStatues->toArray();
        $this->assertModelData($purchaseStatues->toArray(), $dbPurchaseStatues);
    }

    /**
     * @test update
     */
    public function test_update_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();
        $fakePurchaseStatues = PurchaseStatues::factory()->make()->toArray();

        $updatedPurchaseStatues = $this->purchaseStatuesRepo->update($fakePurchaseStatues, $purchaseStatues->id);

        $this->assertModelData($fakePurchaseStatues, $updatedPurchaseStatues->toArray());
        $dbPurchaseStatues = $this->purchaseStatuesRepo->find($purchaseStatues->id);
        $this->assertModelData($fakePurchaseStatues, $dbPurchaseStatues->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_purchase_statues()
    {
        $purchaseStatues = PurchaseStatues::factory()->create();

        $resp = $this->purchaseStatuesRepo->delete($purchaseStatues->id);

        $this->assertTrue($resp);
        $this->assertNull(PurchaseStatues::find($purchaseStatues->id), 'PurchaseStatues should not exist in DB');
    }
}
