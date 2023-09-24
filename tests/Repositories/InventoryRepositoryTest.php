<?php

namespace Tests\Repositories;

use App\Models\Inventory;
use App\Repositories\InventoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class InventoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected InventoryRepository $inventoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->inventoryRepo = app(InventoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_inventory()
    {
        $inventory = Inventory::factory()->make()->toArray();

        $createdInventory = $this->inventoryRepo->create($inventory);

        $createdInventory = $createdInventory->toArray();
        $this->assertArrayHasKey('id', $createdInventory);
        $this->assertNotNull($createdInventory['id'], 'Created Inventory must have id specified');
        $this->assertNotNull(Inventory::find($createdInventory['id']), 'Inventory with given id must be in DB');
        $this->assertModelData($inventory, $createdInventory);
    }

    /**
     * @test read
     */
    public function test_read_inventory()
    {
        $inventory = Inventory::factory()->create();

        $dbInventory = $this->inventoryRepo->find($inventory->id);

        $dbInventory = $dbInventory->toArray();
        $this->assertModelData($inventory->toArray(), $dbInventory);
    }

    /**
     * @test update
     */
    public function test_update_inventory()
    {
        $inventory = Inventory::factory()->create();
        $fakeInventory = Inventory::factory()->make()->toArray();

        $updatedInventory = $this->inventoryRepo->update($fakeInventory, $inventory->id);

        $this->assertModelData($fakeInventory, $updatedInventory->toArray());
        $dbInventory = $this->inventoryRepo->find($inventory->id);
        $this->assertModelData($fakeInventory, $dbInventory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_inventory()
    {
        $inventory = Inventory::factory()->create();

        $resp = $this->inventoryRepo->delete($inventory->id);

        $this->assertTrue($resp);
        $this->assertNull(Inventory::find($inventory->id), 'Inventory should not exist in DB');
    }
}
