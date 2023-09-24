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
use App\Models\SaleDetail;
use App\Repositories\InventoryRepository;

/**
 * Class SaleAPIController
 */
class SaleAPIController extends AppBaseController
{
    /** @var  SaleRepository */
    private $saleRepository;
    private $inventoryRepository;


    public function __construct(SaleRepository $saleRepo, InventoryRepository $inventoryRepo)
    {
        $this->saleRepository = $saleRepo;
        $this->inventoryRepository = $inventoryRepo;
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

        $sortedSales = $sales->sortByDesc('created_at');

        return $this->sendResponse(SaleResource::collection($sortedSales), 'Sales retrieved successfully');
    }

    /**
     * Store a newly created Sale in storage.
     * POST /sales
     */
    public function store(CreateSaleAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $input['created_by'] = auth()->user()->id;
        $sale = $this->saleRepository->create($input);

        if (isset($request->details) && !empty($request->details)) {

            foreach ($request->details as $product) {
                $product =  array_merge($product, ["sale_id" => $sale->id]);

                SaleDetail::create($product);
                $this->inventoryRepository->saleOpration($product, $sale);
            }
        }

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

        if (isset($request->details)) {

            $sale = Sale::find($id);
            $sale->saleDetails()->forceDelete();

            foreach ($request->details as $product) {
                SaleDetail::create(array_merge($product, ["sale_id" => $sale->id]));

                // Update inventory
                $this->inventoryRepository->saleOpration($product, $sale);
            }
        }

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
