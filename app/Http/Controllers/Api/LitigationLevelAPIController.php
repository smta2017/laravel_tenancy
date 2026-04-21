<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLitigationLevelAPIRequest;
use App\Http\Requests\API\UpdateLitigationLevelAPIRequest;
use App\Models\LitigationLevel;
use App\Repositories\LitigationLevelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LitigationLevelResource;

/**
 * Class LitigationLevelAPIController
 */
class LitigationLevelAPIController extends AppBaseController
{
    /** @var  LitigationLevelRepository */
    private $litigationLevelRepository;

    public function __construct(LitigationLevelRepository $litigationLevelRepo)
    {
        $this->litigationLevelRepository = $litigationLevelRepo;
    }

    /**
     * Display a listing of the LitigationLevels.
     * GET|HEAD /litigation-levels
     */
    public function index(Request $request): JsonResponse
    {
        $litigationLevels = $this->litigationLevelRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            LitigationLevelResource::collection($litigationLevels),
            __('messages.retrieved', ['model' => __('models/litigationLevels.plural')])
        );
    }

    /**
     * Store a newly created LitigationLevel in storage.
     * POST /litigation-levels
     */
    public function store(CreateLitigationLevelAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $litigationLevel = $this->litigationLevelRepository->create($input);

        return $this->sendResponse(
            new LitigationLevelResource($litigationLevel),
            __('messages.saved', ['model' => __('models/litigationLevels.singular')])
        );
    }

    /**
     * Display the specified LitigationLevel.
     * GET|HEAD /litigation-levels/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var LitigationLevel $litigationLevel */
        $litigationLevel = $this->litigationLevelRepository->find($id);

        if (empty($litigationLevel)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationLevels.singular')])
            );
        }

        return $this->sendResponse(
            new LitigationLevelResource($litigationLevel),
            __('messages.retrieved', ['model' => __('models/litigationLevels.singular')])
        );
    }

    /**
     * Update the specified LitigationLevel in storage.
     * PUT/PATCH /litigation-levels/{id}
     */
    public function update($id, UpdateLitigationLevelAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var LitigationLevel $litigationLevel */
        $litigationLevel = $this->litigationLevelRepository->find($id);

        if (empty($litigationLevel)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationLevels.singular')])
            );
        }

        $litigationLevel = $this->litigationLevelRepository->update($input, $id);

        return $this->sendResponse(
            new LitigationLevelResource($litigationLevel),
            __('messages.updated', ['model' => __('models/litigationLevels.singular')])
        );
    }

    /**
     * Remove the specified LitigationLevel from storage.
     * DELETE /litigation-levels/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var LitigationLevel $litigationLevel */
        $litigationLevel = $this->litigationLevelRepository->find($id);

        if (empty($litigationLevel)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationLevels.singular')])
            );
        }

        $litigationLevel->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/litigationLevels.singular')])
        );
    }
}
