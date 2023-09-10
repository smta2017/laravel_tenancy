<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateWarehouseAPIRequest;
use App\Http\Requests\API\UpdateWarehouseAPIRequest;
use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\WarehouseResource;

/**
 * Class WarehouseAPIController
 */
class WarehouseAPIController extends AppBaseController
{
    /** @var  WarehouseRepository */
    private $warehouseRepository;

    public function __construct(WarehouseRepository $warehouseRepo)
    {
        $this->warehouseRepository = $warehouseRepo;
    }

    /**
     * Display a listing of the Warehouses.
     * GET|HEAD /warehouses
     */
    public function index(Request $request): JsonResponse
    {
        $warehouses = $this->warehouseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(WarehouseResource::collection($warehouses), 'Warehouses retrieved successfully');
    }

    /**
     * Store a newly created Warehouse in storage.
     * POST /warehouses
     */
    public function store(CreateWarehouseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $warehouse = $this->warehouseRepository->create($input);

        return $this->sendResponse(new WarehouseResource($warehouse), 'Warehouse saved successfully');
    }

    /**
     * Display the specified Warehouse.
     * GET|HEAD /warehouses/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Warehouse $warehouse */
        $warehouse = $this->warehouseRepository->find($id);

        if (empty($warehouse)) {
            return $this->sendError('Warehouse not found');
        }

        return $this->sendResponse(new WarehouseResource($warehouse), 'Warehouse retrieved successfully');
    }

    /**
     * Update the specified Warehouse in storage.
     * PUT/PATCH /warehouses/{id}
     */
    public function update($id, UpdateWarehouseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Warehouse $warehouse */
        $warehouse = $this->warehouseRepository->find($id);

        if (empty($warehouse)) {
            return $this->sendError('Warehouse not found');
        }

        $warehouse = $this->warehouseRepository->update($input, $id);

        return $this->sendResponse(new WarehouseResource($warehouse), 'Warehouse updated successfully');
    }

    /**
     * Remove the specified Warehouse from storage.
     * DELETE /warehouses/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Warehouse $warehouse */
        $warehouse = $this->warehouseRepository->find($id);

        if (empty($warehouse)) {
            return $this->sendError('Warehouse not found');
        }

        $warehouse->delete();

        return $this->sendSuccess('Warehouse deleted successfully');
    }
}
