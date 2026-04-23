<?php

namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\EventState;

class EventStateApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_event_state()
    {
        $eventState = EventState::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/event-states', $eventState
        );

        $this->assertApiResponse($eventState);
    }

    /**
     * @test
     */
    public function test_read_event_state()
    {
        $eventState = EventState::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/event-states/'.$eventState->id
        );

        $this->assertApiResponse($eventState->toArray());
    }

    /**
     * @test
     */
    public function test_update_event_state()
    {
        $eventState = EventState::factory()->create();
        $editedEventState = EventState::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/event-states/'.$eventState->id,
            $editedEventState
        );

        $this->assertApiResponse($editedEventState);
    }

    /**
     * @test
     */
    public function test_delete_event_state()
    {
        $eventState = EventState::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/event-states/'.$eventState->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/event-states/'.$eventState->id
        );

        $this->response->assertStatus(404);
    }
}
