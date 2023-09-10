<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSaleAPIRequest;
use App\Http\Requests\API\UpdateSaleAPIRequest;
use App\Models\Sale;
use App\Repositories\SaleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\SaleResource;

/**
 * Class SaleAPIController
 */
class SaleAPIController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;

    public function __construct(SaleRepository $saleRepo)
    {
        $this->saleRepository = $saleRepo;
    }

    /**
     * Display a listing of the Sales.
     * GET|HEAD /sales
     */
    public function index(Request $request): JsonResponse
    {
        $sales = $this->saleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SaleResource::collection($sales), 'Sales retrieved successfully');
    }

    /**
     * Store a newly created Sale in storage.
     * POST /sales
     */
    public function store(CreateSaleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $sale = $this->saleRepository->create($input);

        return $this->sendResponse(new SaleResource($sale), 'Sale saved successfully');
    }

    /**
     * Display the specified Sale.
     * GET|HEAD /sales/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        return $this->sendResponse(new SaleResource($sale), 'Sale retrieved successfully');
    }

    /**
     * Update the specified Sale in storage.
     * PUT/PATCH /sales/{id}
     */
    public function update($id, UpdateSaleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $sale = $this->saleRepository->update($input, $id);

        return $this->sendResponse(new SaleResource($sale), 'Sale updated successfully');
    }

    /**
     * Remove the specified Sale from storage.
     * DELETE /sales/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Sale $sale */
        $sale = $this->saleRepository->find($id);

        if (empty($sale)) {
            return $this->sendError('Sale not found');
        }

        $sale->delete();

        return $this->sendSuccess('Sale deleted successfully');
    }
}
