<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\LitigationLevel;

class LitigationLevelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/litigation-levels', $litigationLevel
        );

        $this->assertApiResponse($litigationLevel);
    }

    /**
     * @test
     */
    public function test_read_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/litigation-levels/'.$litigationLevel->id
        );

        $this->assertApiResponse($litigationLevel->toArray());
    }

    /**
     * @test
     */
    public function test_update_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();
        $editedLitigationLevel = LitigationLevel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/litigation-levels/'.$litigationLevel->id,
            $editedLitigationLevel
        );

        $this->assertApiResponse($editedLitigationLevel);
    }

    /**
     * @test
     */
    public function test_delete_litigation_level()
    {
        $litigationLevel = LitigationLevel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/litigation-levels/'.$litigationLevel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/litigation-levels/'.$litigationLevel->id
        );

        $this->response->assertStatus(404);
    }
}
