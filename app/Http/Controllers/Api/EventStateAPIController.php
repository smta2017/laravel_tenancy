<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateEventStateAPIRequest;
use App\Http\Requests\API\UpdateEventStateAPIRequest;
use App\Models\EventState;
use App\Repositories\EventStateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\EventStateResource;

/**
 * Class EventStateAPIController
 */
class EventStateAPIController extends AppBaseController
{
    /** @var  EventStateRepository */
    private $eventStateRepository;

    public function __construct(EventStateRepository $eventStateRepo)
    {
        $this->eventStateRepository = $eventStateRepo;
    }

    /**
     * Display a listing of the EventStates.
     * GET|HEAD /event-states
     */
    public function index(Request $request): JsonResponse
    {
        $eventStates = $this->eventStateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            EventStateResource::collection($eventStates),
            __('messages.retrieved', ['model' => __('models/eventStates.plural')])
        );
    }

    /**
     * Store a newly created EventState in storage.
     * POST /event-states
     */
    public function store(CreateEventStateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $eventState = $this->eventStateRepository->create($input);

        return $this->sendResponse(
            new EventStateResource($eventState),
            __('messages.saved', ['model' => __('models/eventStates.singular')])
        );
    }

    /**
     * Display the specified EventState.
     * GET|HEAD /event-states/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var EventState $eventState */
        $eventState = $this->eventStateRepository->find($id);

        if (empty($eventState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventStates.singular')])
            );
        }

        return $this->sendResponse(
            new EventStateResource($eventState),
            __('messages.retrieved', ['model' => __('models/eventStates.singular')])
        );
    }

    /**
     * Update the specified EventState in storage.
     * PUT/PATCH /event-states/{id}
     */
    public function update($id, UpdateEventStateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var EventState $eventState */
        $eventState = $this->eventStateRepository->find($id);

        if (empty($eventState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventStates.singular')])
            );
        }

        $eventState = $this->eventStateRepository->update($input, $id);

        return $this->sendResponse(
            new EventStateResource($eventState),
            __('messages.updated', ['model' => __('models/eventStates.singular')])
        );
    }

    /**
     * Remove the specified EventState from storage.
     * DELETE /event-states/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var EventState $eventState */
        $eventState = $this->eventStateRepository->find($id);

        if (empty($eventState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/eventStates.singular')])
            );
        }

        $eventState->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/eventStates.singular')])
        );
    }
}
