<?php

namespace Tests\Repositories;

use App\Models\LitigationAuthority;
use App\Repositories\LitigationAuthorityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LitigationAuthorityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected LitigationAuthorityRepository $litigationAuthorityRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->litigationAuthorityRepo = app(LitigationAuthorityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->make()->toArray();

        $createdLitigationAuthority = $this->litigationAuthorityRepo->create($litigationAuthority);

        $createdLitigationAuthority = $createdLitigationAuthority->toArray();
        $this->assertArrayHasKey('id', $createdLitigationAuthority);
        $this->assertNotNull($createdLitigationAuthority['id'], 'Created LitigationAuthority must have id specified');
        $this->assertNotNull(LitigationAuthority::find($createdLitigationAuthority['id']), 'LitigationAuthority with given id must be in DB');
        $this->assertModelData($litigationAuthority, $createdLitigationAuthority);
    }

    /**
     * @test read
     */
    public function test_read_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();

        $dbLitigationAuthority = $this->litigationAuthorityRepo->find($litigationAuthority->id);

        $dbLitigationAuthority = $dbLitigationAuthority->toArray();
        $this->assertModelData($litigationAuthority->toArray(), $dbLitigationAuthority);
    }

    /**
     * @test update
     */
    public function test_update_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();
        $fakeLitigationAuthority = LitigationAuthority::factory()->make()->toArray();

        $updatedLitigationAuthority = $this->litigationAuthorityRepo->update($fakeLitigationAuthority, $litigationAuthority->id);

        $this->assertModelData($fakeLitigationAuthority, $updatedLitigationAuthority->toArray());
        $dbLitigationAuthority = $this->litigationAuthorityRepo->find($litigationAuthority->id);
        $this->assertModelData($fakeLitigationAuthority, $dbLitigationAuthority->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();

        $resp = $this->litigationAuthorityRepo->delete($litigationAuthority->id);

        $this->assertTrue($resp);
        $this->assertNull(LitigationAuthority::find($litigationAuthority->id), 'LitigationAuthority should not exist in DB');
    }
}
