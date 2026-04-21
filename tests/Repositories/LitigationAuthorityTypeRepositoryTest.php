<?php

namespace Tests\Repositories;

use App\Models\LitigationAuthorityType;
use App\Repositories\LitigationAuthorityTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LitigationAuthorityTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected LitigationAuthorityTypeRepository $litigationAuthorityTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->litigationAuthorityTypeRepo = app(LitigationAuthorityTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->make()->toArray();

        $createdLitigationAuthorityType = $this->litigationAuthorityTypeRepo->create($litigationAuthorityType);

        $createdLitigationAuthorityType = $createdLitigationAuthorityType->toArray();
        $this->assertArrayHasKey('id', $createdLitigationAuthorityType);
        $this->assertNotNull($createdLitigationAuthorityType['id'], 'Created LitigationAuthorityType must have id specified');
        $this->assertNotNull(LitigationAuthorityType::find($createdLitigationAuthorityType['id']), 'LitigationAuthorityType with given id must be in DB');
        $this->assertModelData($litigationAuthorityType, $createdLitigationAuthorityType);
    }

    /**
     * @test read
     */
    public function test_read_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();

        $dbLitigationAuthorityType = $this->litigationAuthorityTypeRepo->find($litigationAuthorityType->id);

        $dbLitigationAuthorityType = $dbLitigationAuthorityType->toArray();
        $this->assertModelData($litigationAuthorityType->toArray(), $dbLitigationAuthorityType);
    }

    /**
     * @test update
     */
    public function test_update_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();
        $fakeLitigationAuthorityType = LitigationAuthorityType::factory()->make()->toArray();

        $updatedLitigationAuthorityType = $this->litigationAuthorityTypeRepo->update($fakeLitigationAuthorityType, $litigationAuthorityType->id);

        $this->assertModelData($fakeLitigationAuthorityType, $updatedLitigationAuthorityType->toArray());
        $dbLitigationAuthorityType = $this->litigationAuthorityTypeRepo->find($litigationAuthorityType->id);
        $this->assertModelData($fakeLitigationAuthorityType, $dbLitigationAuthorityType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();

        $resp = $this->litigationAuthorityTypeRepo->delete($litigationAuthorityType->id);

        $this->assertTrue($resp);
        $this->assertNull(LitigationAuthorityType::find($litigationAuthorityType->id), 'LitigationAuthorityType should not exist in DB');
    }
}
