<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttachAPIRequest;
use App\Http\Requests\API\UpdateAttachAPIRequest;
use App\Models\Attach;
use App\Repositories\AttachRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AttachResource;

/**
 * Class AttachAPIController
 */
class AttachAPIController extends AppBaseController
{
    /** @var  AttachRepository */
    private $attachRepository;

    public function __construct(AttachRepository $attachRepo)
    {
        $this->attachRepository = $attachRepo;
    }

    /**
     * Display a listing of the Attaches.
     * GET|HEAD /attaches
     */
    public function index(Request $request): JsonResponse
    {
        $attaches = $this->attachRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            AttachResource::collection($attaches),
            __('messages.retrieved', ['model' => __('models/attaches.plural')])
        );
    }

    /**
     * Store a newly created Attach in storage.
     * POST /attaches
     */
    public function store(CreateAttachAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $attach = $this->attachRepository->create($input);

        return $this->sendResponse(
            new AttachResource($attach),
            __('messages.saved', ['model' => __('models/attaches.singular')])
        );
    }

    /**
     * Display the specified Attach.
     * GET|HEAD /attaches/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Attach $attach */
        $attach = $this->attachRepository->find($id);

        if (empty($attach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attaches.singular')])
            );
        }

        return $this->sendResponse(
            new AttachResource($attach),
            __('messages.retrieved', ['model' => __('models/attaches.singular')])
        );
    }

    /**
     * Update the specified Attach in storage.
     * PUT/PATCH /attaches/{id}
     */
    public function update($id, UpdateAttachAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Attach $attach */
        $attach = $this->attachRepository->find($id);

        if (empty($attach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attaches.singular')])
            );
        }

        $attach = $this->attachRepository->update($input, $id);

        return $this->sendResponse(
            new AttachResource($attach),
            __('messages.updated', ['model' => __('models/attaches.singular')])
        );
    }

    /**
     * Remove the specified Attach from storage.
     * DELETE /attaches/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Attach $attach */
        $attach = $this->attachRepository->find($id);

        if (empty($attach)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attaches.singular')])
            );
        }

        $attach->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/attaches.singular')])
        );
    }
}
