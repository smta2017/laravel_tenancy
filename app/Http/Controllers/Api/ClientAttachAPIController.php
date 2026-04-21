<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateClientAttachAPIRequest;
use App\Http\Requests\API\UpdateClientAttachAPIRequest;
use App\Models\ClientAttach;
use App\Repositories\ClientAttachRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ClientAttachResource;

/**
 * Class ClientAttachAPIController
 */
class ClientAttachAPIController extends AppBaseController
{
    /** @var  ClientAttachRepository */
    private $clientAttachRepository;

    public function __construct(ClientAttachRepository $clientAttachRepo)
    {
        $this->clientAttachRepository = $clientAttachRepo;
    }

    /**
     * Display a listing of the ClientAttaches.
     * GET|HEAD /client-attaches
     */
    public function index(Request $request): JsonResponse
    {
        $clientAttaches = $this->clientAttachRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            ClientAttachResource::collection($clientAttaches),
            __('messages.retrieved', ['model' => __('models/clientAttaches.plural')])
        );
    }

    /**
     * Store a newly created ClientAttach in storage.
     * POST /client-attaches
     */
    public function store(CreateClientAttachAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $clientAttach = $this->clientAttachRepository->create($input);

        return $this->sendResponse(
            new ClientAttachResource($clientAttach),
            __('messages.saved', ['model' => __('models/clientAttaches.singular')])
        );
    }

    /**
     * Display the specified ClientAttach.
     * GET|HEAD /client-attaches/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ClientAttach $clientAttach */
        $clientAttach = $this->clientAttachRepository->find($id);

        if (empty($clientAttach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/clientAttaches.singular')])
            );
        }

        return $this->sendResponse(
            new ClientAttachResource($clientAttach),
            __('messages.retrieved', ['model' => __('models/clientAttaches.singular')])
        );
    }

    /**
     * Update the specified ClientAttach in storage.
     * PUT/PATCH /client-attaches/{id}
     */
    public function update($id, UpdateClientAttachAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ClientAttach $clientAttach */
        $clientAttach = $this->clientAttachRepository->find($id);

        if (empty($clientAttach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/clientAttaches.singular')])
            );
        }

        $clientAttach = $this->clientAttachRepository->update($input, $id);

        return $this->sendResponse(
            new ClientAttachResource($clientAttach),
            __('messages.updated', ['model' => __('models/clientAttaches.singular')])
        );
    }

    /**
     * Remove the specified ClientAttach from storage.
     * DELETE /client-attaches/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ClientAttach $clientAttach */
        $clientAttach = $this->clientAttachRepository->find($id);

        if (empty($clientAttach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/clientAttaches.singular')])
            );
        }

        $clientAttach->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/clientAttaches.singular')])
        );
    }
}
