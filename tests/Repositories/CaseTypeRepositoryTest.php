<?php

namespace Tests\Repositories;

use App\Models\CaseType;
use App\Repositories\CaseTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CaseTypeRepository $caseTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseTypeRepo = app(CaseTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case_type()
    {
        $caseType = CaseType::factory()->make()->toArray();

        $createdCaseType = $this->caseTypeRepo->create($caseType);

        $createdCaseType = $createdCaseType->toArray();
        $this->assertArrayHasKey('id', $createdCaseType);
        $this->assertNotNull($createdCaseType['id'], 'Created CaseType must have id specified');
        $this->assertNotNull(CaseType::find($createdCaseType['id']), 'CaseType with given id must be in DB');
        $this->assertModelData($caseType, $createdCaseType);
    }

    /**
     * @test read
     */
    public function test_read_case_type()
    {
        $caseType = CaseType::factory()->create();

        $dbCaseType = $this->caseTypeRepo->find($caseType->id);

        $dbCaseType = $dbCaseType->toArray();
        $this->assertModelData($caseType->toArray(), $dbCaseType);
    }

    /**
     * @test update
     */
    public function test_update_case_type()
    {
        $caseType = CaseType::factory()->create();
        $fakeCaseType = CaseType::factory()->make()->toArray();

        $updatedCaseType = $this->caseTypeRepo->update($fakeCaseType, $caseType->id);

        $this->assertModelData($fakeCaseType, $updatedCaseType->toArray());
        $dbCaseType = $this->caseTypeRepo->find($caseType->id);
        $this->assertModelData($fakeCaseType, $dbCaseType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case_type()
    {
        $caseType = CaseType::factory()->create();

        $resp = $this->caseTypeRepo->delete($caseType->id);

        $this->assertTrue($resp);
        $this->assertNull(CaseType::find($caseType->id), 'CaseType should not exist in DB');
    }
}
