<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePurchaseAPIRequest;
use App\Http\Requests\API\UpdatePurchaseAPIRequest;
use App\Models\Purchase;
use App\Repositories\PurchaseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PurchaseResource;
use App\Models\Inventory;
use App\Models\PurchaseDetails;
use App\Repositories\InventoryRepository;

/**
 * Class PurchaseAPIController
 */
class PurchaseAPIController extends AppBaseController
{
    /** @var  PurchaseRepository */
    private $purchaseRepository;
    private $inventoryRepository;

    public function __construct(PurchaseRepository $purchaseRepo, InventoryRepository $inventoryRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
        $this->inventoryRepository = $inventoryRepo;
    }

    /**
     * Display a listing of the Purchases.
     * GET|HEAD /purchases
     */
    public function index(Request $request): JsonResponse
    {
        $purchases = $this->purchaseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        // Sort the purchases by created_at in descending order
        $sortedPurchases = $purchases->sortByDesc('created_at');

        return $this->sendResponse(PurchaseResource::collection($sortedPurchases), 'Purchases retrieved successfully');
    }

    /**
     * Store a newly created Purchase in storage.
     * POST /purchases
     */
    public function store(CreatePurchaseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $input['created_by'] = auth()->user()->id;
        $purchase = $this->purchaseRepository->create($input);

        if (isset($request->details) && !empty($request->details)) {

            foreach ($request->details as $product) {
                $product =  array_merge($product, ["purchase_id" => $purchase->id]);

                PurchaseDetails::create($product);
                $this->inventoryRepository->updateInventory($product, $purchase);
            }
        }

        return $this->sendResponse(new PurchaseResource($purchase), 'Purchase saved successfully');
    }

    /**
     * Display the specified Purchase.
     * GET|HEAD /purchases/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        return $this->sendResponse(new PurchaseResource($purchase), 'Purchase retrieved successfully');
    }

    /**
     * Update the specified Purchase in storage.
     * PUT/PATCH /purchases/{id}
     */
    public function update($id, UpdatePurchaseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        $purchase = $this->purchaseRepository->update($input, $id);

        if (isset($request->details)) {

            $purchase = Purchase::find($id);
            $purchase->purchaseDetails()->forceDelete();

            foreach ($request->details as $product) {
                PurchaseDetails::create(array_merge($product, ["purchase_id" => $purchase->id]));

                // Update inventory
                $this->inventoryRepository->updateInventory($product, $purchase);
            }
        }

        return $this->sendResponse(new PurchaseResource($purchase), 'Purchase updated successfully');
    }

    /**
     * Remove the specified Purchase from storage.
     * DELETE /purchases/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Purchase $purchase */
        $purchase = $this->purchaseRepository->find($id);

        if (empty($purchase)) {
            return $this->sendError('Purchase not found');
        }

        $purchase->delete();

        return $this->sendSuccess('Purchase deleted successfully');
    }
}
