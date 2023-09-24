<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateInventoryAPIRequest;
use App\Http\Requests\API\UpdateInventoryAPIRequest;
use App\Models\Inventory;
use App\Repositories\InventoryRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\InventoryResource;

/**
 * Class InventoryAPIController
 */
class InventoryAPIController extends AppBaseController
{
    /** @var  InventoryRepository */
    private $inventoryRepository;

    public function __construct(InventoryRepository $inventoryRepo)
    {
        $this->inventoryRepository = $inventoryRepo;
    }

    /**
     * Display a listing of the Inventories.
     * GET|HEAD /inventories
     */
    public function index(Request $request): JsonResponse
    {
        $inventories = $this->inventoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(InventoryResource::collection($inventories), 'Inventories retrieved successfully');
    }

    /**
     * Store a newly created Inventory in storage.
     * POST /inventories
     */
    public function store(CreateInventoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $inventory = $this->inventoryRepository->create($input);

        return $this->sendResponse(new InventoryResource($inventory), 'Inventory saved successfully');
    }

    /**
     * Display the specified Inventory.
     * GET|HEAD /inventories/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        return $this->sendResponse(new InventoryResource($inventory), 'Inventory retrieved successfully');
    }

    /**
     * Update the specified Inventory in storage.
     * PUT/PATCH /inventories/{id}
     */
    public function update($id, UpdateInventoryAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory = $this->inventoryRepository->update($input, $id);

        return $this->sendResponse(new InventoryResource($inventory), 'Inventory updated successfully');
    }

    /**
     * Remove the specified Inventory from storage.
     * DELETE /inventories/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Inventory $inventory */
        $inventory = $this->inventoryRepository->find($id);

        if (empty($inventory)) {
            return $this->sendError('Inventory not found');
        }

        $inventory->delete();

        return $this->sendSuccess('Inventory deleted successfully');
    }
}
