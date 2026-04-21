<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CaseDetails;

class CaseDetailsApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case_details()
    {
        $caseDetails = CaseDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case-details', $caseDetails
        );

        $this->assertApiResponse($caseDetails);
    }

    /**
     * @test
     */
    public function test_read_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/case-details/'.$caseDetails->id
        );

        $this->assertApiResponse($caseDetails->toArray());
    }

    /**
     * @test
     */
    public function test_update_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();
        $editedCaseDetails = CaseDetails::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case-details/'.$caseDetails->id,
            $editedCaseDetails
        );

        $this->assertApiResponse($editedCaseDetails);
    }

    /**
     * @test
     */
    public function test_delete_case_details()
    {
        $caseDetails = CaseDetails::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case-details/'.$caseDetails->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case-details/'.$caseDetails->id
        );

        $this->response->assertStatus(404);
    }
}
