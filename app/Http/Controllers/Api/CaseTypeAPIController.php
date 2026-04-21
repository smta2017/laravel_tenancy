<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateCaseTypeAPIRequest;
use App\Http\Requests\API\UpdateCaseTypeAPIRequest;
use App\Models\CaseType;
use App\Repositories\CaseTypeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\CaseTypeResource;

/**
 * Class CaseTypeAPIController
 */
class CaseTypeAPIController extends AppBaseController
{
    /** @var  CaseTypeRepository */
    private $caseTypeRepository;

    public function __construct(CaseTypeRepository $caseTypeRepo)
    {
        $this->caseTypeRepository = $caseTypeRepo;
    }

    /**
     * Display a listing of the CaseTypes.
     * GET|HEAD /case-types
     */
    public function index(Request $request): JsonResponse
    {
        $caseTypes = $this->caseTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CaseTypeResource::collection($caseTypes),
            __('messages.retrieved', ['model' => __('models/caseTypes.plural')])
        );
    }

    /**
     * Store a newly created CaseType in storage.
     * POST /case-types
     */
    public function store(CreateCaseTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $caseType = $this->caseTypeRepository->create($input);

        return $this->sendResponse(
            new CaseTypeResource($caseType),
            __('messages.saved', ['model' => __('models/caseTypes.singular')])
        );
    }

    /**
     * Display the specified CaseType.
     * GET|HEAD /case-types/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CaseType $caseType */
        $caseType = $this->caseTypeRepository->find($id);

        if (empty($caseType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseTypes.singular')])
            );
        }

        return $this->sendResponse(
            new CaseTypeResource($caseType),
            __('messages.retrieved', ['model' => __('models/caseTypes.singular')])
        );
    }

    /**
     * Update the specified CaseType in storage.
     * PUT/PATCH /case-types/{id}
     */
    public function update($id, UpdateCaseTypeAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CaseType $caseType */
        $caseType = $this->caseTypeRepository->find($id);

        if (empty($caseType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseTypes.singular')])
            );
        }

        $caseType = $this->caseTypeRepository->update($input, $id);

        return $this->sendResponse(
            new CaseTypeResource($caseType),
            __('messages.updated', ['model' => __('models/caseTypes.singular')])
        );
    }

    /**
     * Remove the specified CaseType from storage.
     * DELETE /case-types/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CaseType $caseType */
        $caseType = $this->caseTypeRepository->find($id);

        if (empty($caseType)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/caseTypes.singular')])
            );
        }

        $caseType->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/caseTypes.singular')])
        );
    }
}
