<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseDetailsClientAPIRequest;
use App\Http\Requests\API\UpdateCaseDetailsClientAPIRequest;
use App\Models\CaseDetailsClient;
use App\Repositories\CaseDetailsClientRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CaseDetailsClientResource;

/**
 * Class CaseDetailsClientAPIController
 */
class CaseDetailsClientAPIController extends AppBaseController
{
    /** @var  CaseDetailsClientRepository */
    private $caseDetailsClientRepository;

    public function __construct(CaseDetailsClientRepository $caseDetailsClientRepo)
    {
        $this->caseDetailsClientRepository = $caseDetailsClientRepo;
    }

    /**
     * Display a listing of the CaseDetailsClients.
     * GET|HEAD /case-details-clients
     */
    public function index(Request $request): JsonResponse
    {
        $caseDetailsClients = $this->caseDetailsClientRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CaseDetailsClientResource::collection($caseDetailsClients),
            __('messages.retrieved', ['model' => __('models/caseDetailsClients.plural')])
        );
    }

    /**
     * Store a newly created CaseDetailsClient in storage.
     * POST /case-details-clients
     */
    public function store(CreateCaseDetailsClientAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $caseDetailsClient = $this->caseDetailsClientRepository->create($input);

        return $this->sendResponse(
            new CaseDetailsClientResource($caseDetailsClient),
            __('messages.saved', ['model' => __('models/caseDetailsClients.singular')])
        );
    }

    /**
     * Display the specified CaseDetailsClient.
     * GET|HEAD /case-details-clients/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CaseDetailsClient $caseDetailsClient */
        $caseDetailsClient = $this->caseDetailsClientRepository->find($id);

        if (empty($caseDetailsClient)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailsClients.singular')])
            );
        }

        return $this->sendResponse(
            new CaseDetailsClientResource($caseDetailsClient),
            __('messages.retrieved', ['model' => __('models/caseDetailsClients.singular')])
        );
    }

    /**
     * Update the specified CaseDetailsClient in storage.
     * PUT/PATCH /case-details-clients/{id}
     */
    public function update($id, UpdateCaseDetailsClientAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CaseDetailsClient $caseDetailsClient */
        $caseDetailsClient = $this->caseDetailsClientRepository->find($id);

        if (empty($caseDetailsClient)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailsClients.singular')])
            );
        }

        $caseDetailsClient = $this->caseDetailsClientRepository->update($input, $id);

        return $this->sendResponse(
            new CaseDetailsClientResource($caseDetailsClient),
            __('messages.updated', ['model' => __('models/caseDetailsClients.singular')])
        );
    }

    /**
     * Remove the specified CaseDetailsClient from storage.
     * DELETE /case-details-clients/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CaseDetailsClient $caseDetailsClient */
        $caseDetailsClient = $this->caseDetailsClientRepository->find($id);

        if (empty($caseDetailsClient)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseDetailsClients.singular')])
            );
        }

        $caseDetailsClient->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/caseDetailsClients.singular')])
        );
    }
}
