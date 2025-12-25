<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\TheCase;

class TheCaseApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_the_case()
    {
        $theCase = TheCase::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/the-cases', $theCase
        );

        $this->assertApiResponse($theCase);
    }

    /**
     * @test
     */
    public function test_read_the_case()
    {
        $theCase = TheCase::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/the-cases/'.$theCase->id
        );

        $this->assertApiResponse($theCase->toArray());
    }

    /**
     * @test
     */
    public function test_update_the_case()
    {
        $theCase = TheCase::factory()->create();
        $editedTheCase = TheCase::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/the-cases/'.$theCase->id,
            $editedTheCase
        );

        $this->assertApiResponse($editedTheCase);
    }

    /**
     * @test
     */
    public function test_delete_the_case()
    {
        $theCase = TheCase::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/the-cases/'.$theCase->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/the-cases/'.$theCase->id
        );

        $this->response->assertStatus(404);
    }
}
