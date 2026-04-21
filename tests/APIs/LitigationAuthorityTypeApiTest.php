<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LitigationAuthorityType;

class LitigationAuthorityTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/litigation-authority-types', $litigationAuthorityType
        );

        $this->assertApiResponse($litigationAuthorityType);
    }

    /**
     * @test
     */
    public function test_read_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/litigation-authority-types/'.$litigationAuthorityType->id
        );

        $this->assertApiResponse($litigationAuthorityType->toArray());
    }

    /**
     * @test
     */
    public function test_update_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();
        $editedLitigationAuthorityType = LitigationAuthorityType::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/litigation-authority-types/'.$litigationAuthorityType->id,
            $editedLitigationAuthorityType
        );

        $this->assertApiResponse($editedLitigationAuthorityType);
    }

    /**
     * @test
     */
    public function test_delete_litigation_authority_type()
    {
        $litigationAuthorityType = LitigationAuthorityType::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/litigation-authority-types/'.$litigationAuthorityType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/litigation-authority-types/'.$litigationAuthorityType->id
        );

        $this->response->assertStatus(404);
    }
}
