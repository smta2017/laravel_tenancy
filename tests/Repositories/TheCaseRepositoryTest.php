<?php

namespace Tests\Repositories;

use App\Models\TheCase;
use App\Repositories\TheCaseRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TheCaseRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected TheCaseRepository $theCaseRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->theCaseRepo = app(TheCaseRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_the_case()
    {
        $theCase = TheCase::factory()->make()->toArray();

        $createdTheCase = $this->theCaseRepo->create($theCase);

        $createdTheCase = $createdTheCase->toArray();
        $this->assertArrayHasKey('id', $createdTheCase);
        $this->assertNotNull($createdTheCase['id'], 'Created TheCase must have id specified');
        $this->assertNotNull(TheCase::find($createdTheCase['id']), 'TheCase with given id must be in DB');
        $this->assertModelData($theCase, $createdTheCase);
    }

    /**
     * @test read
     */
    public function test_read_the_case()
    {
        $theCase = TheCase::factory()->create();

        $dbTheCase = $this->theCaseRepo->find($theCase->id);

        $dbTheCase = $dbTheCase->toArray();
        $this->assertModelData($theCase->toArray(), $dbTheCase);
    }

    /**
     * @test update
     */
    public function test_update_the_case()
    {
        $theCase = TheCase::factory()->create();
        $fakeTheCase = TheCase::factory()->make()->toArray();

        $updatedTheCase = $this->theCaseRepo->update($fakeTheCase, $theCase->id);

        $this->assertModelData($fakeTheCase, $updatedTheCase->toArray());
        $dbTheCase = $this->theCaseRepo->find($theCase->id);
        $this->assertModelData($fakeTheCase, $dbTheCase->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_the_case()
    {
        $theCase = TheCase::factory()->create();

        $resp = $this->theCaseRepo->delete($theCase->id);

        $this->assertTrue($resp);
        $this->assertNull(TheCase::find($theCase->id), 'TheCase should not exist in DB');
    }
}
