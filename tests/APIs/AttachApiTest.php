<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Attach;

class AttachApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attach()
    {
        $attach = Attach::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/attaches', $attach
        );

        $this->assertApiResponse($attach);
    }

    /**
     * @test
     */
    public function test_read_attach()
    {
        $attach = Attach::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/attaches/'.$attach->id
        );

        $this->assertApiResponse($attach->toArray());
    }

    /**
     * @test
     */
    public function test_update_attach()
    {
        $attach = Attach::factory()->create();
        $editedAttach = Attach::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/attaches/'.$attach->id,
            $editedAttach
        );

        $this->assertApiResponse($editedAttach);
    }

    /**
     * @test
     */
    public function test_delete_attach()
    {
        $attach = Attach::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/attaches/'.$attach->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/attaches/'.$attach->id
        );

        $this->response->assertStatus(404);
    }
}
