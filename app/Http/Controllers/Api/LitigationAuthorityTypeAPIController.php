<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLitigationAuthorityTypeAPIRequest;
use App\Http\Requests\API\UpdateLitigationAuthorityTypeAPIRequest;
use App\Models\LitigationAuthorityType;
use App\Repositories\LitigationAuthorityTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LitigationAuthorityTypeResource;

/**
 * Class LitigationAuthorityTypeAPIController
 */
class LitigationAuthorityTypeAPIController extends AppBaseController
{
    /** @var  LitigationAuthorityTypeRepository */
    private $litigationAuthorityTypeRepository;

    public function __construct(LitigationAuthorityTypeRepository $litigationAuthorityTypeRepo)
    {
        $this->litigationAuthorityTypeRepository = $litigationAuthorityTypeRepo;
    }

    /**
     * Display a listing of the LitigationAuthorityTypes.
     * GET|HEAD /litigation-authority-types
     */
    public function index(Request $request): JsonResponse
    {
        $litigationAuthorityTypes = $this->litigationAuthorityTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            LitigationAuthorityTypeResource::collection($litigationAuthorityTypes),
            __('messages.retrieved', ['model' => __('models/litigationAuthorityTypes.plural')])
        );
    }

    /**
     * Store a newly created LitigationAuthorityType in storage.
     * POST /litigation-authority-types
     */
    public function store(CreateLitigationAuthorityTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $litigationAuthorityType = $this->litigationAuthorityTypeRepository->create($input);

        return $this->sendResponse(
            new LitigationAuthorityTypeResource($litigationAuthorityType),
            __('messages.saved', ['model' => __('models/litigationAuthorityTypes.singular')])
        );
    }

    /**
     * Display the specified LitigationAuthorityType.
     * GET|HEAD /litigation-authority-types/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var LitigationAuthorityType $litigationAuthorityType */
        $litigationAuthorityType = $this->litigationAuthorityTypeRepository->find($id);

        if (empty($litigationAuthorityType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorityTypes.singular')])
            );
        }

        return $this->sendResponse(
            new LitigationAuthorityTypeResource($litigationAuthorityType),
            __('messages.retrieved', ['model' => __('models/litigationAuthorityTypes.singular')])
        );
    }

    /**
     * Update the specified LitigationAuthorityType in storage.
     * PUT/PATCH /litigation-authority-types/{id}
     */
    public function update($id, UpdateLitigationAuthorityTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var LitigationAuthorityType $litigationAuthorityType */
        $litigationAuthorityType = $this->litigationAuthorityTypeRepository->find($id);

        if (empty($litigationAuthorityType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorityTypes.singular')])
            );
        }

        $litigationAuthorityType = $this->litigationAuthorityTypeRepository->update($input, $id);

        return $this->sendResponse(
            new LitigationAuthorityTypeResource($litigationAuthorityType),
            __('messages.updated', ['model' => __('models/litigationAuthorityTypes.singular')])
        );
    }

    /**
     * Remove the specified LitigationAuthorityType from storage.
     * DELETE /litigation-authority-types/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var LitigationAuthorityType $litigationAuthorityType */
        $litigationAuthorityType = $this->litigationAuthorityTypeRepository->find($id);

        if (empty($litigationAuthorityType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorityTypes.singular')])
            );
        }

        $litigationAuthorityType->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/litigationAuthorityTypes.singular')])
        );
    }
}
