<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTheCaseAPIRequest;
use App\Http\Requests\API\UpdateTheCaseAPIRequest;
use App\Models\TheCase;
use App\Repositories\TheCaseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\TheCaseResource;

/**
 * Class TheCaseAPIController
 */
class TheCaseAPIController extends AppBaseController
{
    /** @var  TheCaseRepository */
    private $theCaseRepository;

    public function __construct(TheCaseRepository $theCaseRepo)
    {
        $this->theCaseRepository = $theCaseRepo;
    }

    /**
     * Display a listing of the TheCases.
     * GET|HEAD /the-cases
     */
    public function index(Request $request): JsonResponse
    {
        $theCases = $this->theCaseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        if ($request->has('with')) {
            $theCases->load(explode(',', $request->get('with')));
        }

        return $this->sendResponse(
            TheCaseResource::collection($theCases),
            __('messages.retrieved', ['model' => __('models/theCases.plural')])
        );
    }

    /**
     * Store a newly created TheCase in storage.
     * POST /the-cases
     */
    public function store(CreateTheCaseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $theCase = $this->theCaseRepository->create($input);

        return $this->sendResponse(
            new TheCaseResource($theCase),
            __('messages.saved', ['model' => __('models/theCases.singular')])
        );
    }

    /**
     * Display the specified TheCase.
     * GET|HEAD /the-cases/{id}
     */
    public function show($id, Request $request): JsonResponse
    {
        /** @var TheCase $theCase */
        $theCase = $this->theCaseRepository->find($id);

        if (empty($theCase)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/theCases.singular')])
            );
        }

        if ($request->has('with')) {
            $theCase->load(explode(',', $request->get('with')));
        } else {
            // Best practice: Standardize returning details for single view
            $theCase->load(['caseDetails.clients']);
        }

        return $this->sendResponse(
            new TheCaseResource($theCase),
            __('messages.retrieved', ['model' => __('models/theCases.singular')])
        );
    }

    /**
     * Update the specified TheCase in storage.
     * PUT/PATCH /the-cases/{id}
     */
    public function update($id, UpdateTheCaseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var TheCase $theCase */
        $theCase = $this->theCaseRepository->find($id);

        if (empty($theCase)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/theCases.singular')])
            );
        }

        $theCase = $this->theCaseRepository->update($input, $id);

        return $this->sendResponse(
            new TheCaseResource($theCase),
            __('messages.updated', ['model' => __('models/theCases.singular')])
        );
    }

    /**
     * Remove the specified TheCase from storage.
     * DELETE /the-cases/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var TheCase $theCase */
        $theCase = $this->theCaseRepository->find($id);

        if (empty($theCase)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/theCases.singular')])
            );
        }

        $theCase->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/theCases.singular')])
        );
    }
}
