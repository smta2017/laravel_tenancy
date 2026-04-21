<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContractBandAPIRequest;
use App\Http\Requests\API\UpdateContractBandAPIRequest;
use App\Models\ContractBand;
use App\Repositories\ContractBandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ContractBandResource;

/**
 * Class ContractBandAPIController
 */
class ContractBandAPIController extends AppBaseController
{
    /** @var  ContractBandRepository */
    private $contractBandRepository;

    public function __construct(ContractBandRepository $contractBandRepo)
    {
        $this->contractBandRepository = $contractBandRepo;
    }

    /**
     * Display a listing of the ContractBands.
     * GET|HEAD /contract-bands
     */
    public function index(Request $request): JsonResponse
    {
        $contractBands = $this->contractBandRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            ContractBandResource::collection($contractBands),
            __('messages.retrieved', ['model' => __('models/contractBands.plural')])
        );
    }

    /**
     * Store a newly created ContractBand in storage.
     * POST /contract-bands
     */
    public function store(CreateContractBandAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $contractBand = $this->contractBandRepository->create($input);

        return $this->sendResponse(
            new ContractBandResource($contractBand),
            __('messages.saved', ['model' => __('models/contractBands.singular')])
        );
    }

    /**
     * Display the specified ContractBand.
     * GET|HEAD /contract-bands/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var ContractBand $contractBand */
        $contractBand = $this->contractBandRepository->find($id);

        if (empty($contractBand)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contractBands.singular')])
            );
        }

        return $this->sendResponse(
            new ContractBandResource($contractBand),
            __('messages.retrieved', ['model' => __('models/contractBands.singular')])
        );
    }

    /**
     * Update the specified ContractBand in storage.
     * PUT/PATCH /contract-bands/{id}
     */
    public function update($id, UpdateContractBandAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var ContractBand $contractBand */
        $contractBand = $this->contractBandRepository->find($id);

        if (empty($contractBand)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contractBands.singular')])
            );
        }

        $contractBand = $this->contractBandRepository->update($input, $id);

        return $this->sendResponse(
            new ContractBandResource($contractBand),
            __('messages.updated', ['model' => __('models/contractBands.singular')])
        );
    }

    /**
     * Remove the specified ContractBand from storage.
     * DELETE /contract-bands/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var ContractBand $contractBand */
        $contractBand = $this->contractBandRepository->find($id);

        if (empty($contractBand)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/contractBands.singular')])
            );
        }

        $contractBand->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/contractBands.singular')])
        );
    }
}
