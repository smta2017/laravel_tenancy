<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContractAPIRequest;
use App\Http\Requests\API\UpdateContractAPIRequest;
use App\Models\Contract;
use App\Repositories\ContractRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ContractResource;

/**
 * Class ContractAPIController
 */
class ContractAPIController extends AppBaseController
{
    /** @var  ContractRepository */
    private $contractRepository;

    public function __construct(ContractRepository $contractRepo)
    {
        $this->contractRepository = $contractRepo;
    }

    /**
     * Display a listing of the Contracts.
     * GET|HEAD /contracts
     */
    public function index(Request $request): JsonResponse
    {
        $contracts = $this->contractRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            ContractResource::collection($contracts),
            __('messages.retrieved', ['model' => __('models/contracts.plural')])
        );
    }

    /**
     * Store a newly created Contract in storage.
     * POST /contracts
     */
    public function store(CreateContractAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $contract = $this->contractRepository->create($input);

        return $this->sendResponse(
            new ContractResource($contract),
            __('messages.saved', ['model' => __('models/contracts.singular')])
        );
    }

    /**
     * Display the specified Contract.
     * GET|HEAD /contracts/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contracts.singular')])
            );
        }

        return $this->sendResponse(
            new ContractResource($contract),
            __('messages.retrieved', ['model' => __('models/contracts.singular')])
        );
    }

    /**
     * Update the specified Contract in storage.
     * PUT/PATCH /contracts/{id}
     */
    public function update($id, UpdateContractAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contracts.singular')])
            );
        }

        $contract = $this->contractRepository->update($input, $id);

        return $this->sendResponse(
            new ContractResource($contract),
            __('messages.updated', ['model' => __('models/contracts.singular')])
        );
    }

    /**
     * Remove the specified Contract from storage.
     * DELETE /contracts/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contracts.singular')])
            );
        }

        $contract->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/contracts.singular')])
        );
    }
}
