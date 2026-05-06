<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseDetailEventAPIRequest;
use App\Http\Requests\API\UpdateCaseDetailEventAPIRequest;
use App\Models\CaseDetailEvent;
use App\Repositories\CaseDetailEventRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CaseDetailEventResource;
use Illuminate\Support\Facades\Auth;

/**
 * Class CaseDetailEventAPIController
 */
class CaseDetailEventAPIController extends AppBaseController
{
    /** @var  CaseDetailEventRepository */
    private $caseDetailEventRepository;

    public function __construct(CaseDetailEventRepository $caseDetailEventRepo)
    {
        $this->caseDetailEventRepository = $caseDetailEventRepo;
    }

    /**
     * Display a listing of the CaseDetailEvents.
     * GET|HEAD /case-detail-events
     */
    public function index(Request $request): JsonResponse
    {
        $caseDetailEvents = $this->caseDetailEventRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CaseDetailEventResource::collection($caseDetailEvents),
            __('messages.retrieved', ['model' => __('models/caseDetailEvents.plural')])
        );
    }

    /**
     * Store a newly created CaseDetailEvent in storage.
     * POST /case-detail-events
     */
    public function store(CreateCaseDetailEventAPIRequest $request): JsonResponse
    {
        $input = $request->all();
        $input['created_by'] = Auth::id();

        $caseDetailEvent = $this->caseDetailEventRepository->create($input);

        return $this->sendResponse(
            new CaseDetailEventResource($caseDetailEvent),
            __('messages.saved', ['model' => __('models/caseDetailEvents.singular')])
        );
    }

    /**
     * Display the specified CaseDetailEvent.
     * GET|HEAD /case-detail-events/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CaseDetailEvent $caseDetailEvent */
        $caseDetailEvent = $this->caseDetailEventRepository->find($id);

        if (empty($caseDetailEvent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailEvents.singular')])
            );
        }

        return $this->sendResponse(
            new CaseDetailEventResource($caseDetailEvent),
            __('messages.retrieved', ['model' => __('models/caseDetailEvents.singular')])
        );
    }

    /**
     * Update the specified CaseDetailEvent in storage.
     * PUT/PATCH /case-detail-events/{id}
     */
    public function update($id, UpdateCaseDetailEventAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CaseDetailEvent $caseDetailEvent */
        $caseDetailEvent = $this->caseDetailEventRepository->find($id);

        if (empty($caseDetailEvent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailEvents.singular')])
            );
        }

        $caseDetailEvent = $this->caseDetailEventRepository->update($input, $id);

        return $this->sendResponse(
            new CaseDetailEventResource($caseDetailEvent),
            __('messages.updated', ['model' => __('models/caseDetailEvents.singular')])
        );
    }

    /**
     * Remove the specified CaseDetailEvent from storage.
     * DELETE /case-detail-events/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CaseDetailEvent $caseDetailEvent */
        $caseDetailEvent = $this->caseDetailEventRepository->find($id);

        if (empty($caseDetailEvent)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailEvents.singular')])
            );
        }

        $caseDetailEvent->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/caseDetailEvents.singular')])
        );
    }
}
