<?php

namespace Tests\Repositories;

use App\Models\CaseDetails;
use App\Repositories\CaseDetailsRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseDetailsRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CaseDetailsRepository $caseDetailsRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseDetailsRepo = app(CaseDetailsRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case_details()
    {
        $caseDetails = CaseDetails::factory()->make()->toArray();

        $createdCaseDetails = $this->caseDetailsRepo->create($caseDetails);

        $createdCaseDetails = $createdCaseDetails->toArray();
        $this->assertArrayHasKey('id', $createdCaseDetails);
        $this->assertNotNull($createdCaseDetails['id'], 'Created CaseDetails must have id specified');
        $this->assertNotNull(CaseDetails::find($createdCaseDetails['id']), 'CaseDetails with given id must be in DB');
        $this->assertModelData($caseDetails, $createdCaseDetails);
    }

    /**
     * @test read
     */
    public function test_read_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();

        $dbCaseDetails = $this->caseDetailsRepo->find($caseDetails->id);

        $dbCaseDetails = $dbCaseDetails->toArray();
        $this->assertModelData($caseDetails->toArray(), $dbCaseDetails);
    }

    /**
     * @test update
     */
    public function test_update_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();
        $fakeCaseDetails = CaseDetails::factory()->make()->toArray();

        $updatedCaseDetails = $this->caseDetailsRepo->update($fakeCaseDetails, $caseDetails->id);

        $this->assertModelData($fakeCaseDetails, $updatedCaseDetails->toArray());
        $dbCaseDetails = $this->caseDetailsRepo->find($caseDetails->id);
        $this->assertModelData($fakeCaseDetails, $dbCaseDetails->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();

        $resp = $this->caseDetailsRepo->delete($caseDetails->id);

        $this->assertTrue($resp);
        $this->assertNull(CaseDetails::find($caseDetails->id), 'CaseDetails should not exist in DB');
    }
}
