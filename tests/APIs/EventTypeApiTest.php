<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\EventType;

class EventTypeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_event_type()
    {
        $eventType = EventType::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/event-types', $eventType
        );

        $this->assertApiResponse($eventType);
    }

    /**
     * @test
     */
    public function test_read_event_type()
    {
        $eventType = EventType::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/event-types/'.$eventType->id
        );

        $this->assertApiResponse($eventType->toArray());
    }

    /**
     * @test
     */
    public function test_update_event_type()
    {
        $eventType = EventType::factory()->create();
        $editedEventType = EventType::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/event-types/'.$eventType->id,
            $editedEventType
        );

        $this->assertApiResponse($editedEventType);
    }

    /**
     * @test
     */
    public function test_delete_event_type()
    {
        $eventType = EventType::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/event-types/'.$eventType->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/event-types/'.$eventType->id
        );

        $this->response->assertStatus(404);
    }
}
