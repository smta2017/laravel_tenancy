<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseStateAPIRequest;
use App\Http\Requests\API\UpdateCaseStateAPIRequest;
use App\Models\CaseState;
use App\Repositories\CaseStateRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CaseStateResource;

/**
 * Class CaseStateAPIController
 */
class CaseStateAPIController extends AppBaseController
{
    /** @var  CaseStateRepository */
    private $caseStateRepository;

    public function __construct(CaseStateRepository $caseStateRepo)
    {
        $this->caseStateRepository = $caseStateRepo;
    }

    /**
     * Display a listing of the CaseStates.
     * GET|HEAD /case-states
     */
    public function index(Request $request): JsonResponse
    {
        $caseStates = $this->caseStateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CaseStateResource::collection($caseStates),
            __('messages.retrieved', ['model' => __('models/caseStates.plural')])
        );
    }

    /**
     * Store a newly created CaseState in storage.
     * POST /case-states
     */
    public function store(CreateCaseStateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $caseState = $this->caseStateRepository->create($input);

        return $this->sendResponse(
            new CaseStateResource($caseState),
            __('messages.saved', ['model' => __('models/caseStates.singular')])
        );
    }

    /**
     * Display the specified CaseState.
     * GET|HEAD /case-states/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CaseState $caseState */
        $caseState = $this->caseStateRepository->find($id);

        if (empty($caseState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseStates.singular')])
            );
        }

        return $this->sendResponse(
            new CaseStateResource($caseState),
            __('messages.retrieved', ['model' => __('models/caseStates.singular')])
        );
    }

    /**
     * Update the specified CaseState in storage.
     * PUT/PATCH /case-states/{id}
     */
    public function update($id, UpdateCaseStateAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CaseState $caseState */
        $caseState = $this->caseStateRepository->find($id);

        if (empty($caseState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseStates.singular')])
            );
        }

        $caseState = $this->caseStateRepository->update($input, $id);

        return $this->sendResponse(
            new CaseStateResource($caseState),
            __('messages.updated', ['model' => __('models/caseStates.singular')])
        );
    }

    /**
     * Remove the specified CaseState from storage.
     * DELETE /case-states/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CaseState $caseState */
        $caseState = $this->caseStateRepository->find($id);

        if (empty($caseState)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseStates.singular')])
            );
        }

        $caseState->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/caseStates.singular')])
        );
    }
}
