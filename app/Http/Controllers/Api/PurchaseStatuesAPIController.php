<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePurchaseStatuesAPIRequest;
use App\Http\Requests\API\UpdatePurchaseStatuesAPIRequest;
use App\Models\PurchaseStatues;
use App\Repositories\PurchaseStatuesRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PurchaseStatuesResource;

/**
 * Class PurchaseStatuesAPIController
 */
class PurchaseStatuesAPIController extends AppBaseController
{
    /** @var  PurchaseStatuesRepository */
    private $purchaseStatuesRepository;

    public function __construct(PurchaseStatuesRepository $purchaseStatuesRepo)
    {
        $this->purchaseStatuesRepository = $purchaseStatuesRepo;
    }

    /**
     * Display a listing of the PurchaseStatues.
     * GET|HEAD /purchase-statues
     */
    public function index(Request $request): JsonResponse
    {
        $purchaseStatues = $this->purchaseStatuesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PurchaseStatuesResource::collection($purchaseStatues), 'Purchase Statues retrieved successfully');
    }

    /**
     * Store a newly created PurchaseStatues in storage.
     * POST /purchase-statues
     */
    public function store(CreatePurchaseStatuesAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $purchaseStatues = $this->purchaseStatuesRepository->create($input);

        return $this->sendResponse(new PurchaseStatuesResource($purchaseStatues), 'Purchase Statues saved successfully');
    }

    /**
     * Display the specified PurchaseStatues.
     * GET|HEAD /purchase-statues/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PurchaseStatues $purchaseStatues */
        $purchaseStatues = $this->purchaseStatuesRepository->find($id);

        if (empty($purchaseStatues)) {
            return $this->sendError('Purchase Statues not found');
        }

        return $this->sendResponse(new PurchaseStatuesResource($purchaseStatues), 'Purchase Statues retrieved successfully');
    }

    /**
     * Update the specified PurchaseStatues in storage.
     * PUT/PATCH /purchase-statues/{id}
     */
    public function update($id, UpdatePurchaseStatuesAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PurchaseStatues $purchaseStatues */
        $purchaseStatues = $this->purchaseStatuesRepository->find($id);

        if (empty($purchaseStatues)) {
            return $this->sendError('Purchase Statues not found');
        }

        $purchaseStatues = $this->purchaseStatuesRepository->update($input, $id);

        return $this->sendResponse(new PurchaseStatuesResource($purchaseStatues), 'PurchaseStatues updated successfully');
    }

    /**
     * Remove the specified PurchaseStatues from storage.
     * DELETE /purchase-statues/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PurchaseStatues $purchaseStatues */
        $purchaseStatues = $this->purchaseStatuesRepository->find($id);

        if (empty($purchaseStatues)) {
            return $this->sendError('Purchase Statues not found');
        }

        $purchaseStatues->delete();

        return $this->sendSuccess('Purchase Statues deleted successfully');
    }
}
