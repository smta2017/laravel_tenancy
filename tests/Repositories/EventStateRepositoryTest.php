<?php

namespace Tests\Repositories;

use App\Models\EventState;
use App\Repositories\EventStateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EventStateRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected EventStateRepository $eventStateRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->eventStateRepo = app(EventStateRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_event_state()
    {
        $eventState = EventState::factory()->make()->toArray();

        $createdEventState = $this->eventStateRepo->create($eventState);

        $createdEventState = $createdEventState->toArray();
        $this->assertArrayHasKey('id', $createdEventState);
        $this->assertNotNull($createdEventState['id'], 'Created EventState must have id specified');
        $this->assertNotNull(EventState::find($createdEventState['id']), 'EventState with given id must be in DB');
        $this->assertModelData($eventState, $createdEventState);
    }

    /**
     * @test read
     */
    public function test_read_event_state()
    {
        $eventState = EventState::factory()->create();

        $dbEventState = $this->eventStateRepo->find($eventState->id);

        $dbEventState = $dbEventState->toArray();
        $this->assertModelData($eventState->toArray(), $dbEventState);
    }

    /**
     * @test update
     */
    public function test_update_event_state()
    {
        $eventState = EventState::factory()->create();
        $fakeEventState = EventState::factory()->make()->toArray();

        $updatedEventState = $this->eventStateRepo->update($fakeEventState, $eventState->id);

        $this->assertModelData($fakeEventState, $updatedEventState->toArray());
        $dbEventState = $this->eventStateRepo->find($eventState->id);
        $this->assertModelData($fakeEventState, $dbEventState->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_event_state()
    {
        $eventState = EventState::factory()->create();

        $resp = $this->eventStateRepo->delete($eventState->id);

        $this->assertTrue($resp);
        $this->assertNull(EventState::find($eventState->id), 'EventState should not exist in DB');
    }
}
