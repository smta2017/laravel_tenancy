<?php

namespace Tests\Repositories;

use App\Models\PurchaseDetails;
use App\Repositories\PurchaseDetailsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PurchaseDetailsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected PurchaseDetailsRepository $purchaseDetailsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->purchaseDetailsRepo = app(PurchaseDetailsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->make()->toArray();

        $createdPurchaseDetails = $this->purchaseDetailsRepo->create($purchaseDetails);

        $createdPurchaseDetails = $createdPurchaseDetails->toArray();
        $this->assertArrayHasKey('id', $createdPurchaseDetails);
        $this->assertNotNull($createdPurchaseDetails['id'], 'Created PurchaseDetails must have id specified');
        $this->assertNotNull(PurchaseDetails::find($createdPurchaseDetails['id']), 'PurchaseDetails with given id must be in DB');
        $this->assertModelData($purchaseDetails, $createdPurchaseDetails);
    }

    /**
     * @test read
     */
    public function test_read_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();

        $dbPurchaseDetails = $this->purchaseDetailsRepo->find($purchaseDetails->id);

        $dbPurchaseDetails = $dbPurchaseDetails->toArray();
        $this->assertModelData($purchaseDetails->toArray(), $dbPurchaseDetails);
    }

    /**
     * @test update
     */
    public function test_update_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();
        $fakePurchaseDetails = PurchaseDetails::factory()->make()->toArray();

        $updatedPurchaseDetails = $this->purchaseDetailsRepo->update($fakePurchaseDetails, $purchaseDetails->id);

        $this->assertModelData($fakePurchaseDetails, $updatedPurchaseDetails->toArray());
        $dbPurchaseDetails = $this->purchaseDetailsRepo->find($purchaseDetails->id);
        $this->assertModelData($fakePurchaseDetails, $dbPurchaseDetails->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_purchase_details()
    {
        $purchaseDetails = PurchaseDetails::factory()->create();

        $resp = $this->purchaseDetailsRepo->delete($purchaseDetails->id);

        $this->assertTrue($resp);
        $this->assertNull(PurchaseDetails::find($purchaseDetails->id), 'PurchaseDetails should not exist in DB');
    }
}
