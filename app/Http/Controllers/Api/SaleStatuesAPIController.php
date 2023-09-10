<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleStatuesAPIRequest;
use App\Http\Requests\API\UpdateSaleStatuesAPIRequest;
use App\Models\SaleStatues;
use App\Repositories\SaleStatuesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SaleStatuesResource;

/**
 * Class SaleStatuesAPIController
 */
class SaleStatuesAPIController extends AppBaseController
{
    /** @var  SaleStatuesRepository */
    private $saleStatuesRepository;

    public function __construct(SaleStatuesRepository $saleStatuesRepo)
    {
        $this->saleStatuesRepository = $saleStatuesRepo;
    }

    /**
     * Display a listing of the SaleStatues.
     * GET|HEAD /sale-statues
     */
    public function index(Request $request): JsonResponse
    {
        $saleStatues = $this->saleStatuesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SaleStatuesResource::collection($saleStatues), 'Sale Statues retrieved successfully');
    }

    /**
     * Store a newly created SaleStatues in storage.
     * POST /sale-statues
     */
    public function store(CreateSaleStatuesAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $saleStatues = $this->saleStatuesRepository->create($input);

        return $this->sendResponse(new SaleStatuesResource($saleStatues), 'Sale Statues saved successfully');
    }

    /**
     * Display the specified SaleStatues.
     * GET|HEAD /sale-statues/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var SaleStatues $saleStatues */
        $saleStatues = $this->saleStatuesRepository->find($id);

        if (empty($saleStatues)) {
            return $this->sendError('Sale Statues not found');
        }

        return $this->sendResponse(new SaleStatuesResource($saleStatues), 'Sale Statues retrieved successfully');
    }

    /**
     * Update the specified SaleStatues in storage.
     * PUT/PATCH /sale-statues/{id}
     */
    public function update($id, UpdateSaleStatuesAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var SaleStatues $saleStatues */
        $saleStatues = $this->saleStatuesRepository->find($id);

        if (empty($saleStatues)) {
            return $this->sendError('Sale Statues not found');
        }

        $saleStatues = $this->saleStatuesRepository->update($input, $id);

        return $this->sendResponse(new SaleStatuesResource($saleStatues), 'SaleStatues updated successfully');
    }

    /**
     * Remove the specified SaleStatues from storage.
     * DELETE /sale-statues/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var SaleStatues $saleStatues */
        $saleStatues = $this->saleStatuesRepository->find($id);

        if (empty($saleStatues)) {
            return $this->sendError('Sale Statues not found');
        }

        $saleStatues->delete();

        return $this->sendSuccess('Sale Statues deleted successfully');
    }
}
