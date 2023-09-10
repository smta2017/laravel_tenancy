<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePurchaseDetailsAPIRequest;
use App\Http\Requests\API\UpdatePurchaseDetailsAPIRequest;
use App\Models\PurchaseDetails;
use App\Repositories\PurchaseDetailsRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\PurchaseDetailsResource;

/**
 * Class PurchaseDetailsAPIController
 */
class PurchaseDetailsAPIController extends AppBaseController
{
    /** @var  PurchaseDetailsRepository */
    private $purchaseDetailsRepository;

    public function __construct(PurchaseDetailsRepository $purchaseDetailsRepo)
    {
        $this->purchaseDetailsRepository = $purchaseDetailsRepo;
    }

    /**
     * Display a listing of the PurchaseDetails.
     * GET|HEAD /purchase-details
     */
    public function index(Request $request): JsonResponse
    {
        $purchaseDetails = $this->purchaseDetailsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PurchaseDetailsResource::collection($purchaseDetails), 'Purchase Details retrieved successfully');
    }

    /**
     * Store a newly created PurchaseDetails in storage.
     * POST /purchase-details
     */
    public function store(CreatePurchaseDetailsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $purchaseDetails = $this->purchaseDetailsRepository->create($input);

        return $this->sendResponse(new PurchaseDetailsResource($purchaseDetails), 'Purchase Details saved successfully');
    }

    /**
     * Display the specified PurchaseDetails.
     * GET|HEAD /purchase-details/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var PurchaseDetails $purchaseDetails */
        $purchaseDetails = $this->purchaseDetailsRepository->find($id);

        if (empty($purchaseDetails)) {
            return $this->sendError('Purchase Details not found');
        }

        return $this->sendResponse(new PurchaseDetailsResource($purchaseDetails), 'Purchase Details retrieved successfully');
    }

    /**
     * Update the specified PurchaseDetails in storage.
     * PUT/PATCH /purchase-details/{id}
     */
    public function update($id, UpdatePurchaseDetailsAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var PurchaseDetails $purchaseDetails */
        $purchaseDetails = $this->purchaseDetailsRepository->find($id);

        if (empty($purchaseDetails)) {
            return $this->sendError('Purchase Details not found');
        }

        $purchaseDetails = $this->purchaseDetailsRepository->update($input, $id);

        return $this->sendResponse(new PurchaseDetailsResource($purchaseDetails), 'PurchaseDetails updated successfully');
    }

    /**
     * Remove the specified PurchaseDetails from storage.
     * DELETE /purchase-details/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var PurchaseDetails $purchaseDetails */
        $purchaseDetails = $this->purchaseDetailsRepository->find($id);

        if (empty($purchaseDetails)) {
            return $this->sendError('Purchase Details not found');
        }

        $purchaseDetails->delete();

        return $this->sendSuccess('Purchase Details deleted successfully');
    }
}
