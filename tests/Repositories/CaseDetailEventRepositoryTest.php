<?php

namespace Tests\Repositories;

use App\Models\CaseDetailEvent;
use App\Repositories\CaseDetailEventRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CaseDetailEventRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected CaseDetailEventRepository $caseDetailEventRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->caseDetailEventRepo = app(CaseDetailEventRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->make()->toArray();

        $createdCaseDetailEvent = $this->caseDetailEventRepo->create($caseDetailEvent);

        $createdCaseDetailEvent = $createdCaseDetailEvent->toArray();
        $this->assertArrayHasKey('id', $createdCaseDetailEvent);
        $this->assertNotNull($createdCaseDetailEvent['id'], 'Created CaseDetailEvent must have id specified');
        $this->assertNotNull(CaseDetailEvent::find($createdCaseDetailEvent['id']), 'CaseDetailEvent with given id must be in DB');
        $this->assertModelData($caseDetailEvent, $createdCaseDetailEvent);
    }

    /**
     * @test read
     */
    public function test_read_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();

        $dbCaseDetailEvent = $this->caseDetailEventRepo->find($caseDetailEvent->id);

        $dbCaseDetailEvent = $dbCaseDetailEvent->toArray();
        $this->assertModelData($caseDetailEvent->toArray(), $dbCaseDetailEvent);
    }

    /**
     * @test update
     */
    public function test_update_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();
        $fakeCaseDetailEvent = CaseDetailEvent::factory()->make()->toArray();

        $updatedCaseDetailEvent = $this->caseDetailEventRepo->update($fakeCaseDetailEvent, $caseDetailEvent->id);

        $this->assertModelData($fakeCaseDetailEvent, $updatedCaseDetailEvent->toArray());
        $dbCaseDetailEvent = $this->caseDetailEventRepo->find($caseDetailEvent->id);
        $this->assertModelData($fakeCaseDetailEvent, $dbCaseDetailEvent->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();

        $resp = $this->caseDetailEventRepo->delete($caseDetailEvent->id);

        $this->assertTrue($resp);
        $this->assertNull(CaseDetailEvent::find($caseDetailEvent->id), 'CaseDetailEvent should not exist in DB');
    }
}
