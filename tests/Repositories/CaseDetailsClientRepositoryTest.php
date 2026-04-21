<?php

namespace Tests\Repositories;

use App\Models\CaseDetailsClient;
use App\Repositories\CaseDetailsClientRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseDetailsClientRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CaseDetailsClientRepository $caseDetailsClientRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseDetailsClientRepo = app(CaseDetailsClientRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->make()->toArray();

        $createdCaseDetailsClient = $this->caseDetailsClientRepo->create($caseDetailsClient);

        $createdCaseDetailsClient = $createdCaseDetailsClient->toArray();
        $this->assertArrayHasKey('id', $createdCaseDetailsClient);
        $this->assertNotNull($createdCaseDetailsClient['id'], 'Created CaseDetailsClient must have id specified');
        $this->assertNotNull(CaseDetailsClient::find($createdCaseDetailsClient['id']), 'CaseDetailsClient with given id must be in DB');
        $this->assertModelData($caseDetailsClient, $createdCaseDetailsClient);
    }

    /**
     * @test read
     */
    public function test_read_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();

        $dbCaseDetailsClient = $this->caseDetailsClientRepo->find($caseDetailsClient->id);

        $dbCaseDetailsClient = $dbCaseDetailsClient->toArray();
        $this->assertModelData($caseDetailsClient->toArray(), $dbCaseDetailsClient);
    }

    /**
     * @test update
     */
    public function test_update_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();
        $fakeCaseDetailsClient = CaseDetailsClient::factory()->make()->toArray();

        $updatedCaseDetailsClient = $this->caseDetailsClientRepo->update($fakeCaseDetailsClient, $caseDetailsClient->id);

        $this->assertModelData($fakeCaseDetailsClient, $updatedCaseDetailsClient->toArray());
        $dbCaseDetailsClient = $this->caseDetailsClientRepo->find($caseDetailsClient->id);
        $this->assertModelData($fakeCaseDetailsClient, $dbCaseDetailsClient->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();

        $resp = $this->caseDetailsClientRepo->delete($caseDetailsClient->id);

        $this->assertTrue($resp);
        $this->assertNull(CaseDetailsClient::find($caseDetailsClient->id), 'CaseDetailsClient should not exist in DB');
    }
}
