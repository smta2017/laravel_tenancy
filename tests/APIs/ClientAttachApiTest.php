<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ClientAttach;

class ClientAttachApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_client_attach()
    {
        $clientAttach = ClientAttach::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/client-attaches', $clientAttach
        );

        $this->assertApiResponse($clientAttach);
    }

    /**
     * @test
     */
    public function test_read_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/client-attaches/'.$clientAttach->id
        );

        $this->assertApiResponse($clientAttach->toArray());
    }

    /**
     * @test
     */
    public function test_update_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();
        $editedClientAttach = ClientAttach::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/client-attaches/'.$clientAttach->id,
            $editedClientAttach
        );

        $this->assertApiResponse($editedClientAttach);
    }

    /**
     * @test
     */
    public function test_delete_client_attach()
    {
        $clientAttach = ClientAttach::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/client-attaches/'.$clientAttach->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/client-attaches/'.$clientAttach->id
        );

        $this->response->assertStatus(404);
    }
}
