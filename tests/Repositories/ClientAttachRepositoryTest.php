<?php

namespace Tests\Repositories;

use App\Models\ClientAttach;
use App\Repositories\ClientAttachRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ClientAttachRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected ClientAttachRepository $clientAttachRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->clientAttachRepo = app(ClientAttachRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_client_attach()
    {
        $clientAttach = ClientAttach::factory()->make()->toArray();

        $createdClientAttach = $this->clientAttachRepo->create($clientAttach);

        $createdClientAttach = $createdClientAttach->toArray();
        $this->assertArrayHasKey('id', $createdClientAttach);
        $this->assertNotNull($createdClientAttach['id'], 'Created ClientAttach must have id specified');
        $this->assertNotNull(ClientAttach::find($createdClientAttach['id']), 'ClientAttach with given id must be in DB');
        $this->assertModelData($clientAttach, $createdClientAttach);
    }

    /**
     * @test read
     */
    public function test_read_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();

        $dbClientAttach = $this->clientAttachRepo->find($clientAttach->id);

        $dbClientAttach = $dbClientAttach->toArray();
        $this->assertModelData($clientAttach->toArray(), $dbClientAttach);
    }

    /**
     * @test update
     */
    public function test_update_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();
        $fakeClientAttach = ClientAttach::factory()->make()->toArray();

        $updatedClientAttach = $this->clientAttachRepo->update($fakeClientAttach, $clientAttach->id);

        $this->assertModelData($fakeClientAttach, $updatedClientAttach->toArray());
        $dbClientAttach = $this->clientAttachRepo->find($clientAttach->id);
        $this->assertModelData($fakeClientAttach, $dbClientAttach->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();

        $resp = $this->clientAttachRepo->delete($clientAttach->id);

        $this->assertTrue($resp);
        $this->assertNull(ClientAttach::find($clientAttach->id), 'ClientAttach should not exist in DB');
    }
}
