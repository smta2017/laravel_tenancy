<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CaseDetailsClient;

class CaseDetailsClientApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case-details-clients', $caseDetailsClient
        );

        $this->assertApiResponse($caseDetailsClient);
    }

    /**
     * @test
     */
    public function test_read_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/case-details-clients/'.$caseDetailsClient->id
        );

        $this->assertApiResponse($caseDetailsClient->toArray());
    }

    /**
     * @test
     */
    public function test_update_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();
        $editedCaseDetailsClient = CaseDetailsClient::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case-details-clients/'.$caseDetailsClient->id,
            $editedCaseDetailsClient
        );

        $this->assertApiResponse($editedCaseDetailsClient);
    }

    /**
     * @test
     */
    public function test_delete_case_details_client()
    {
        $caseDetailsClient = CaseDetailsClient::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case-details-clients/'.$caseDetailsClient->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case-details-clients/'.$caseDetailsClient->id
        );

        $this->response->assertStatus(404);
    }
}
