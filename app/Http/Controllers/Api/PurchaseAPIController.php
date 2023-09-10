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

/**
 * Class PurchaseAPIController
 */
class PurchaseAPIController extends AppBaseController
{
    /** @var  PurchaseRepository */
    private $purchaseRepository;

    public function __construct(PurchaseRepository $purchaseRepo)
    {
        $this->purchaseRepository = $purchaseRepo;
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

        return $this->sendResponse(PurchaseResource::collection($purchases), 'Purchases retrieved successfully');
    }

    /**
     * Store a newly created Purchase in storage.
     * POST /purchases
     */
    public function store(CreatePurchaseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $purchase = $this->purchaseRepository->create($input);

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
