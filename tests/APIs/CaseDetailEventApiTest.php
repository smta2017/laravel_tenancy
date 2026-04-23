<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CaseDetailEvent;

class CaseDetailEventApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case-detail-events', $caseDetailEvent
        );

        $this->assertApiResponse($caseDetailEvent);
    }

    /**
     * @test
     */
    public function test_read_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/case-detail-events/'.$caseDetailEvent->id
        );

        $this->assertApiResponse($caseDetailEvent->toArray());
    }

    /**
     * @test
     */
    public function test_update_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();
        $editedCaseDetailEvent = CaseDetailEvent::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case-detail-events/'.$caseDetailEvent->id,
            $editedCaseDetailEvent
        );

        $this->assertApiResponse($editedCaseDetailEvent);
    }

    /**
     * @test
     */
    public function test_delete_case_detail_event()
    {
        $caseDetailEvent = CaseDetailEvent::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case-detail-events/'.$caseDetailEvent->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case-detail-events/'.$caseDetailEvent->id
        );

        $this->response->assertStatus(404);
    }
}
