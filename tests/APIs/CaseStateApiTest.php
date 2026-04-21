<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CaseState;

class CaseStateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case_state()
    {
        $caseState = CaseState::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case-states', $caseState
        );

        $this->assertApiResponse($caseState);
    }

    /**
     * @test
     */
    public function test_read_case_state()
    {
        $caseState = CaseState::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/case-states/'.$caseState->id
        );

        $this->assertApiResponse($caseState->toArray());
    }

    /**
     * @test
     */
    public function test_update_case_state()
    {
        $caseState = CaseState::factory()->create();
        $editedCaseState = CaseState::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case-states/'.$caseState->id,
            $editedCaseState
        );

        $this->assertApiResponse($editedCaseState);
    }

    /**
     * @test
     */
    public function test_delete_case_state()
    {
        $caseState = CaseState::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case-states/'.$caseState->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case-states/'.$caseState->id
        );

        $this->response->assertStatus(404);
    }
}
