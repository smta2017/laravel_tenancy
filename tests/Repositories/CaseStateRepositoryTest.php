<?php

namespace Tests\Repositories;

use App\Models\CaseState;
use App\Repositories\CaseStateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseStateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CaseStateRepository $caseStateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseStateRepo = app(CaseStateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case_state()
    {
        $caseState = CaseState::factory()->make()->toArray();

        $createdCaseState = $this->caseStateRepo->create($caseState);

        $createdCaseState = $createdCaseState->toArray();
        $this->assertArrayHasKey('id', $createdCaseState);
        $this->assertNotNull($createdCaseState['id'], 'Created CaseState must have id specified');
        $this->assertNotNull(CaseState::find($createdCaseState['id']), 'CaseState with given id must be in DB');
        $this->assertModelData($caseState, $createdCaseState);
    }

    /**
     * @test read
     */
    public function test_read_case_state()
    {
        $caseState = CaseState::factory()->create();

        $dbCaseState = $this->caseStateRepo->find($caseState->id);

        $dbCaseState = $dbCaseState->toArray();
        $this->assertModelData($caseState->toArray(), $dbCaseState);
    }

    /**
     * @test update
     */
    public function test_update_case_state()
    {
        $caseState = CaseState::factory()->create();
        $fakeCaseState = CaseState::factory()->make()->toArray();

        $updatedCaseState = $this->caseStateRepo->update($fakeCaseState, $caseState->id);

        $this->assertModelData($fakeCaseState, $updatedCaseState->toArray());
        $dbCaseState = $this->caseStateRepo->find($caseState->id);
        $this->assertModelData($fakeCaseState, $dbCaseState->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case_state()
    {
        $caseState = CaseState::factory()->create();

        $resp = $this->caseStateRepo->delete($caseState->id);

        $this->assertTrue($resp);
        $this->assertNull(CaseState::find($caseState->id), 'CaseState should not exist in DB');
    }
}
