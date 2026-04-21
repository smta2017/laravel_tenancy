<?php

namespace Tests\Repositories;

use App\Models\LitigationLevel;
use App\Repositories\LitigationLevelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LitigationLevelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected LitigationLevelRepository $litigationLevelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->litigationLevelRepo = app(LitigationLevelRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->make()->toArray();

        $createdLitigationLevel = $this->litigationLevelRepo->create($litigationLevel);

        $createdLitigationLevel = $createdLitigationLevel->toArray();
        $this->assertArrayHasKey('id', $createdLitigationLevel);
        $this->assertNotNull($createdLitigationLevel['id'], 'Created LitigationLevel must have id specified');
        $this->assertNotNull(LitigationLevel::find($createdLitigationLevel['id']), 'LitigationLevel with given id must be in DB');
        $this->assertModelData($litigationLevel, $createdLitigationLevel);
    }

    /**
     * @test read
     */
    public function test_read_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();

        $dbLitigationLevel = $this->litigationLevelRepo->find($litigationLevel->id);

        $dbLitigationLevel = $dbLitigationLevel->toArray();
        $this->assertModelData($litigationLevel->toArray(), $dbLitigationLevel);
    }

    /**
     * @test update
     */
    public function test_update_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();
        $fakeLitigationLevel = LitigationLevel::factory()->make()->toArray();

        $updatedLitigationLevel = $this->litigationLevelRepo->update($fakeLitigationLevel, $litigationLevel->id);

        $this->assertModelData($fakeLitigationLevel, $updatedLitigationLevel->toArray());
        $dbLitigationLevel = $this->litigationLevelRepo->find($litigationLevel->id);
        $this->assertModelData($fakeLitigationLevel, $dbLitigationLevel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();

        $resp = $this->litigationLevelRepo->delete($litigationLevel->id);

        $this->assertTrue($resp);
        $this->assertNull(LitigationLevel::find($litigationLevel->id), 'LitigationLevel should not exist in DB');
    }
}
