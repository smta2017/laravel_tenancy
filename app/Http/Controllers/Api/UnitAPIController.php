<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUnitAPIRequest;
use App\Http\Requests\API\UpdateUnitAPIRequest;
use App\Models\Unit;
use App\Repositories\UnitRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\UnitResource;

/**
 * Class UnitAPIController
 */
class UnitAPIController extends AppBaseController
{
    /** @var  UnitRepository */
    private $unitRepository;

    public function __construct(UnitRepository $unitRepo)
    {
        $this->unitRepository = $unitRepo;
    }

    /**
     * Display a listing of the Units.
     * GET|HEAD /units
     */
    public function index(Request $request): JsonResponse
    {
        $units = $this->unitRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(UnitResource::collection($units), 'Units retrieved successfully');
    }

    /**
     * Store a newly created Unit in storage.
     * POST /units
     */
    public function store(CreateUnitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $unit = $this->unitRepository->create($input);

        return $this->sendResponse(new UnitResource($unit), 'Unit saved successfully');
    }

    /**
     * Display the specified Unit.
     * GET|HEAD /units/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Unit $unit */
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            return $this->sendError('Unit not found');
        }

        return $this->sendResponse(new UnitResource($unit), 'Unit retrieved successfully');
    }

    /**
     * Update the specified Unit in storage.
     * PUT/PATCH /units/{id}
     */
    public function update($id, UpdateUnitAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Unit $unit */
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            return $this->sendError('Unit not found');
        }

        $unit = $this->unitRepository->update($input, $id);

        return $this->sendResponse(new UnitResource($unit), 'Unit updated successfully');
    }

    /**
     * Remove the specified Unit from storage.
     * DELETE /units/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Unit $unit */
        $unit = $this->unitRepository->find($id);

        if (empty($unit)) {
            return $this->sendError('Unit not found');
        }

        $unit->delete();

        return $this->sendSuccess('Unit deleted successfully');
    }
}
