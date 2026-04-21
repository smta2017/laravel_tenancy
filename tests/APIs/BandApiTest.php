<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Band;

class BandApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_band()
    {
        $band = Band::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/bands', $band
        );

        $this->assertApiResponse($band);
    }

    /**
     * @test
     */
    public function test_read_band()
    {
        $band = Band::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/bands/'.$band->id
        );

        $this->assertApiResponse($band->toArray());
    }

    /**
     * @test
     */
    public function test_update_band()
    {
        $band = Band::factory()->create();
        $editedBand = Band::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/bands/'.$band->id,
            $editedBand
        );

        $this->assertApiResponse($editedBand);
    }

    /**
     * @test
     */
    public function test_delete_band()
    {
        $band = Band::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/bands/'.$band->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/bands/'.$band->id
        );

        $this->response->assertStatus(404);
    }
}
