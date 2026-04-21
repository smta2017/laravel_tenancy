<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CaseType;

class CaseTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_case_type()
    {
        $caseType = CaseType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/case-types', $caseType
        );

        $this->assertApiResponse($caseType);
    }

    /**
     * @test
     */
    public function test_read_case_type()
    {
        $caseType = CaseType::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/case-types/'.$caseType->id
        );

        $this->assertApiResponse($caseType->toArray());
    }

    /**
     * @test
     */
    public function test_update_case_type()
    {
        $caseType = CaseType::factory()->create();
        $editedCaseType = CaseType::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/case-types/'.$caseType->id,
            $editedCaseType
        );

        $this->assertApiResponse($editedCaseType);
    }

    /**
     * @test
     */
    public function test_delete_case_type()
    {
        $caseType = CaseType::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/case-types/'.$caseType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/case-types/'.$caseType->id
        );

        $this->response->assertStatus(404);
    }
}
