<?php

namespace Tests\Repositories;

use App\Models\AttributeOpponent;
use App\Repositories\AttributeOpponentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttributeOpponentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected AttributeOpponentRepository $attributeOpponentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attributeOpponentRepo = app(AttributeOpponentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->make()->toArray();

        $createdAttributeOpponent = $this->attributeOpponentRepo->create($attributeOpponent);

        $createdAttributeOpponent = $createdAttributeOpponent->toArray();
        $this->assertArrayHasKey('id', $createdAttributeOpponent);
        $this->assertNotNull($createdAttributeOpponent['id'], 'Created AttributeOpponent must have id specified');
        $this->assertNotNull(AttributeOpponent::find($createdAttributeOpponent['id']), 'AttributeOpponent with given id must be in DB');
        $this->assertModelData($attributeOpponent, $createdAttributeOpponent);
    }

    /**
     * @test read
     */
    public function test_read_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();

        $dbAttributeOpponent = $this->attributeOpponentRepo->find($attributeOpponent->id);

        $dbAttributeOpponent = $dbAttributeOpponent->toArray();
        $this->assertModelData($attributeOpponent->toArray(), $dbAttributeOpponent);
    }

    /**
     * @test update
     */
    public function test_update_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();
        $fakeAttributeOpponent = AttributeOpponent::factory()->make()->toArray();

        $updatedAttributeOpponent = $this->attributeOpponentRepo->update($fakeAttributeOpponent, $attributeOpponent->id);

        $this->assertModelData($fakeAttributeOpponent, $updatedAttributeOpponent->toArray());
        $dbAttributeOpponent = $this->attributeOpponentRepo->find($attributeOpponent->id);
        $this->assertModelData($fakeAttributeOpponent, $dbAttributeOpponent->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attribute_opponent()
    {
        $attributeOpponent = AttributeOpponent::factory()->create();

        $resp = $this->attributeOpponentRepo->delete($attributeOpponent->id);

        $this->assertTrue($resp);
        $this->assertNull(AttributeOpponent::find($attributeOpponent->id), 'AttributeOpponent should not exist in DB');
    }
}
