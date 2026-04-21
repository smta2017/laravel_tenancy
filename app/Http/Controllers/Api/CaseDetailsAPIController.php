<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseDetailsAPIRequest;
use App\Http\Requests\API\UpdateCaseDetailsAPIRequest;
use App\Models\CaseDetails;
use App\Repositories\CaseDetailsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CaseDetailsResource;

/**
 * Class CaseDetailsAPIController
 */
class CaseDetailsAPIController extends AppBaseController
{
    /** @var  CaseDetailsRepository */
    private $caseDetailsRepository;

    public function __construct(CaseDetailsRepository $caseDetailsRepo)
    {
        $this->caseDetailsRepository = $caseDetailsRepo;
    }

    /**
     * Display a listing of the CaseDetails.
     * GET|HEAD /case-details
     */
    public function index(Request $request): JsonResponse
    {
        $caseDetails = $this->caseDetailsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CaseDetailsResource::collection($caseDetails),
            __('messages.retrieved', ['model' => __('models/caseDetails.plural')])
        );
    }

    /**
     * Store a newly created CaseDetails in storage.
     * POST /case-details
     */
    public function store(CreateCaseDetailsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $caseDetails = $this->caseDetailsRepository->create($input);

        return $this->sendResponse(
            new CaseDetailsResource($caseDetails),
            __('messages.saved', ['model' => __('models/caseDetails.singular')])
        );
    }

    /**
     * Display the specified CaseDetails.
     * GET|HEAD /case-details/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CaseDetails $caseDetails */
        $caseDetails = $this->caseDetailsRepository->find($id);

        if (empty($caseDetails)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetails.singular')])
            );
        }

        return $this->sendResponse(
            new CaseDetailsResource($caseDetails),
            __('messages.retrieved', ['model' => __('models/caseDetails.singular')])
        );
    }

    /**
     * Update the specified CaseDetails in storage.
     * PUT/PATCH /case-details/{id}
     */
    public function update($id, UpdateCaseDetailsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CaseDetails $caseDetails */
        $caseDetails = $this->caseDetailsRepository->find($id);

        if (empty($caseDetails)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetails.singular')])
            );
        }

        $caseDetails = $this->caseDetailsRepository->update($input, $id);

        return $this->sendResponse(
            new CaseDetailsResource($caseDetails),
            __('messages.updated', ['model' => __('models/caseDetails.singular')])
        );
    }

    /**
     * Remove the specified CaseDetails from storage.
     * DELETE /case-details/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CaseDetails $caseDetails */
        $caseDetails = $this->caseDetailsRepository->find($id);

        if (empty($caseDetails)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetails.singular')])
            );
        }

        $caseDetails->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/caseDetails.singular')])
        );
    }
}
