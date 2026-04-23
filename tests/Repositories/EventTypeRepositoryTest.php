<?php

namespace Tests\Repositories;

use App\Models\EventType;
use App\Repositories\EventTypeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EventTypeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    protected EventTypeRepository $eventTypeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->eventTypeRepo = app(EventTypeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_event_type()
    {
        $eventType = EventType::factory()->make()->toArray();

        $createdEventType = $this->eventTypeRepo->create($eventType);

        $createdEventType = $createdEventType->toArray();
        $this->assertArrayHasKey('id', $createdEventType);
        $this->assertNotNull($createdEventType['id'], 'Created EventType must have id specified');
        $this->assertNotNull(EventType::find($createdEventType['id']), 'EventType with given id must be in DB');
        $this->assertModelData($eventType, $createdEventType);
    }

    /**
     * @test read
     */
    public function test_read_event_type()
    {
        $eventType = EventType::factory()->create();

        $dbEventType = $this->eventTypeRepo->find($eventType->id);

        $dbEventType = $dbEventType->toArray();
        $this->assertModelData($eventType->toArray(), $dbEventType);
    }

    /**
     * @test update
     */
    public function test_update_event_type()
    {
        $eventType = EventType::factory()->create();
        $fakeEventType = EventType::factory()->make()->toArray();

        $updatedEventType = $this->eventTypeRepo->update($fakeEventType, $eventType->id);

        $this->assertModelData($fakeEventType, $updatedEventType->toArray());
        $dbEventType = $this->eventTypeRepo->find($eventType->id);
        $this->assertModelData($fakeEventType, $dbEventType->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_event_type()
    {
        $eventType = EventType::factory()->create();

        $resp = $this->eventTypeRepo->delete($eventType->id);

        $this->assertTrue($resp);
        $this->assertNull(EventType::find($eventType->id), 'EventType should not exist in DB');
    }
}
