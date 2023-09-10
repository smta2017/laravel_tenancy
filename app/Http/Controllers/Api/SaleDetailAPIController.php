<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleDetailAPIRequest;
use App\Http\Requests\API\UpdateSaleDetailAPIRequest;
use App\Models\SaleDetail;
use App\Repositories\SaleDetailRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SaleDetailResource;

/**
 * Class SaleDetailAPIController
 */
class SaleDetailAPIController extends AppBaseController
{
    /** @var  SaleDetailRepository */
    private $saleDetailRepository;

    public function __construct(SaleDetailRepository $saleDetailRepo)
    {
        $this->saleDetailRepository = $saleDetailRepo;
    }

    /**
     * Display a listing of the SaleDetails.
     * GET|HEAD /sale-details
     */
    public function index(Request $request): JsonResponse
    {
        $saleDetails = $this->saleDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SaleDetailResource::collection($saleDetails), 'Sale Details retrieved successfully');
    }

    /**
     * Store a newly created SaleDetail in storage.
     * POST /sale-details
     */
    public function store(CreateSaleDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $saleDetail = $this->saleDetailRepository->create($input);

        return $this->sendResponse(new SaleDetailResource($saleDetail), 'Sale Detail saved successfully');
    }

    /**
     * Display the specified SaleDetail.
     * GET|HEAD /sale-details/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var SaleDetail $saleDetail */
        $saleDetail = $this->saleDetailRepository->find($id);

        if (empty($saleDetail)) {
            return $this->sendError('Sale Detail not found');
        }

        return $this->sendResponse(new SaleDetailResource($saleDetail), 'Sale Detail retrieved successfully');
    }

    /**
     * Update the specified SaleDetail in storage.
     * PUT/PATCH /sale-details/{id}
     */
    public function update($id, UpdateSaleDetailAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var SaleDetail $saleDetail */
        $saleDetail = $this->saleDetailRepository->find($id);

        if (empty($saleDetail)) {
            return $this->sendError('Sale Detail not found');
        }

        $saleDetail = $this->saleDetailRepository->update($input, $id);

        return $this->sendResponse(new SaleDetailResource($saleDetail), 'SaleDetail updated successfully');
    }

    /**
     * Remove the specified SaleDetail from storage.
     * DELETE /sale-details/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var SaleDetail $saleDetail */
        $saleDetail = $this->saleDetailRepository->find($id);

        if (empty($saleDetail)) {
            return $this->sendError('Sale Detail not found');
        }

        $saleDetail->delete();

        return $this->sendSuccess('Sale Detail deleted successfully');
    }
}
