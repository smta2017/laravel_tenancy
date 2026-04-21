<?php

namespace Tests\Repositories;

use App\Models\Attach;
use App\Repositories\AttachRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttachRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected AttachRepository $attachRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attachRepo = app(AttachRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attach()
    {
        $attach = Attach::factory()->make()->toArray();

        $createdAttach = $this->attachRepo->create($attach);

        $createdAttach = $createdAttach->toArray();
        $this->assertArrayHasKey('id', $createdAttach);
        $this->assertNotNull($createdAttach['id'], 'Created Attach must have id specified');
        $this->assertNotNull(Attach::find($createdAttach['id']), 'Attach with given id must be in DB');
        $this->assertModelData($attach, $createdAttach);
    }

    /**
     * @test read
     */
    public function test_read_attach()
    {
        $attach = Attach::factory()->create();

        $dbAttach = $this->attachRepo->find($attach->id);

        $dbAttach = $dbAttach->toArray();
        $this->assertModelData($attach->toArray(), $dbAttach);
    }

    /**
     * @test update
     */
    public function test_update_attach()
    {
        $attach = Attach::factory()->create();
        $fakeAttach = Attach::factory()->make()->toArray();

        $updatedAttach = $this->attachRepo->update($fakeAttach, $attach->id);

        $this->assertModelData($fakeAttach, $updatedAttach->toArray());
        $dbAttach = $this->attachRepo->find($attach->id);
        $this->assertModelData($fakeAttach, $dbAttach->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attach()
    {
        $attach = Attach::factory()->create();

        $resp = $this->attachRepo->delete($attach->id);

        $this->assertTrue($resp);
        $this->assertNull(Attach::find($attach->id), 'Attach should not exist in DB');
    }
}
