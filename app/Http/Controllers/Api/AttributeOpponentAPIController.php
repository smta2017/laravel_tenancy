<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateAttributeOpponentAPIRequest;
use App\Http\Requests\API\UpdateAttributeOpponentAPIRequest;
use App\Models\AttributeOpponent;
use App\Repositories\AttributeOpponentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\AttributeOpponentResource;

/**
 * Class AttributeOpponentAPIController
 */
class AttributeOpponentAPIController extends AppBaseController
{
    /** @var  AttributeOpponentRepository */
    private $attributeOpponentRepository;

    public function __construct(AttributeOpponentRepository $attributeOpponentRepo)
    {
        $this->attributeOpponentRepository = $attributeOpponentRepo;
    }

    /**
     * Display a listing of the AttributeOpponents.
     * GET|HEAD /attribute-opponents
     */
    public function index(Request $request): JsonResponse
    {
        $attributeOpponents = $this->attributeOpponentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            AttributeOpponentResource::collection($attributeOpponents),
            __('messages.retrieved', ['model' => __('models/attributeOpponents.plural')])
        );
    }

    /**
     * Store a newly created AttributeOpponent in storage.
     * POST /attribute-opponents
     */
    public function store(CreateAttributeOpponentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $attributeOpponent = $this->attributeOpponentRepository->create($input);

        return $this->sendResponse(
            new AttributeOpponentResource($attributeOpponent),
            __('messages.saved', ['model' => __('models/attributeOpponents.singular')])
        );
    }

    /**
     * Display the specified AttributeOpponent.
     * GET|HEAD /attribute-opponents/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var AttributeOpponent $attributeOpponent */
        $attributeOpponent = $this->attributeOpponentRepository->find($id);

        if (empty($attributeOpponent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attributeOpponents.singular')])
            );
        }

        return $this->sendResponse(
            new AttributeOpponentResource($attributeOpponent),
            __('messages.retrieved', ['model' => __('models/attributeOpponents.singular')])
        );
    }

    /**
     * Update the specified AttributeOpponent in storage.
     * PUT/PATCH /attribute-opponents/{id}
     */
    public function update($id, UpdateAttributeOpponentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var AttributeOpponent $attributeOpponent */
        $attributeOpponent = $this->attributeOpponentRepository->find($id);

        if (empty($attributeOpponent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attributeOpponents.singular')])
            );
        }

        $attributeOpponent = $this->attributeOpponentRepository->update($input, $id);

        return $this->sendResponse(
            new AttributeOpponentResource($attributeOpponent),
            __('messages.updated', ['model' => __('models/attributeOpponents.singular')])
        );
    }

    /**
     * Remove the specified AttributeOpponent from storage.
     * DELETE /attribute-opponents/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var AttributeOpponent $attributeOpponent */
        $attributeOpponent = $this->attributeOpponentRepository->find($id);

        if (empty($attributeOpponent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/attributeOpponents.singular')])
            );
        }

        $attributeOpponent->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/attributeOpponents.singular')])
        );
    }
}
