<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LitigationAuthority;

class LitigationAuthorityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/litigation-authorities', $litigationAuthority
        );

        $this->assertApiResponse($litigationAuthority);
    }

    /**
     * @test
     */
    public function test_read_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/litigation-authorities/'.$litigationAuthority->id
        );

        $this->assertApiResponse($litigationAuthority->toArray());
    }

    /**
     * @test
     */
    public function test_update_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();
        $editedLitigationAuthority = LitigationAuthority::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/litigation-authorities/'.$litigationAuthority->id,
            $editedLitigationAuthority
        );

        $this->assertApiResponse($editedLitigationAuthority);
    }

    /**
     * @test
     */
    public function test_delete_litigation_authority()
    {
        $litigationAuthority = LitigationAuthority::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/litigation-authorities/'.$litigationAuthority->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/litigation-authorities/'.$litigationAuthority->id
        );

        $this->response->assertStatus(404);
    }
}
