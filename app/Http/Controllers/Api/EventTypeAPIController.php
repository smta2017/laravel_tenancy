<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEventTypeAPIRequest;
use App\Http\Requests\API\UpdateEventTypeAPIRequest;
use App\Models\EventType;
use App\Repositories\EventTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\EventTypeResource;

/**
 * Class EventTypeAPIController
 */
class EventTypeAPIController extends AppBaseController
{
    /** @var  EventTypeRepository */
    private $eventTypeRepository;

    public function __construct(EventTypeRepository $eventTypeRepo)
    {
        $this->eventTypeRepository = $eventTypeRepo;
    }

    /**
     * Display a listing of the EventTypes.
     * GET|HEAD /event-types
     */
    public function index(Request $request): JsonResponse
    {
        $eventTypes = $this->eventTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            EventTypeResource::collection($eventTypes),
            __('messages.retrieved', ['model' => __('models/eventTypes.plural')])
        );
    }

    /**
     * Store a newly created EventType in storage.
     * POST /event-types
     */
    public function store(CreateEventTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $eventType = $this->eventTypeRepository->create($input);

        return $this->sendResponse(
            new EventTypeResource($eventType),
            __('messages.saved', ['model' => __('models/eventTypes.singular')])
        );
    }

    /**
     * Display the specified EventType.
     * GET|HEAD /event-types/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var EventType $eventType */
        $eventType = $this->eventTypeRepository->find($id);

        if (empty($eventType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventTypes.singular')])
            );
        }

        return $this->sendResponse(
            new EventTypeResource($eventType),
            __('messages.retrieved', ['model' => __('models/eventTypes.singular')])
        );
    }

    /**
     * Update the specified EventType in storage.
     * PUT/PATCH /event-types/{id}
     */
    public function update($id, UpdateEventTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var EventType $eventType */
        $eventType = $this->eventTypeRepository->find($id);

        if (empty($eventType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventTypes.singular')])
            );
        }

        $eventType = $this->eventTypeRepository->update($input, $id);

        return $this->sendResponse(
            new EventTypeResource($eventType),
            __('messages.updated', ['model' => __('models/eventTypes.singular')])
        );
    }

    /**
     * Remove the specified EventType from storage.
     * DELETE /event-types/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var EventType $eventType */
        $eventType = $this->eventTypeRepository->find($id);

        if (empty($eventType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventTypes.singular')])
            );
        }

        $eventType->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/eventTypes.singular')])
        );
    }
}
