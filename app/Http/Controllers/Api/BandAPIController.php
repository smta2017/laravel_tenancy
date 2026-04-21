<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateBandAPIRequest;
use App\Http\Requests\API\UpdateBandAPIRequest;
use App\Models\Band;
use App\Repositories\BandRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\BandResource;

/**
 * Class BandAPIController
 */
class BandAPIController extends AppBaseController
{
    /** @var  BandRepository */
    private $bandRepository;

    public function __construct(BandRepository $bandRepo)
    {
        $this->bandRepository = $bandRepo;
    }

    /**
     * Display a listing of the Bands.
     * GET|HEAD /bands
     */
    public function index(Request $request): JsonResponse
    {
        $bands = $this->bandRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            BandResource::collection($bands),
            __('messages.retrieved', ['model' => __('models/bands.plural')])
        );
    }

    /**
     * Store a newly created Band in storage.
     * POST /bands
     */
    public function store(CreateBandAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $band = $this->bandRepository->create($input);

        return $this->sendResponse(
            new BandResource($band),
            __('messages.saved', ['model' => __('models/bands.singular')])
        );
    }

    /**
     * Display the specified Band.
     * GET|HEAD /bands/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Band $band */
        $band = $this->bandRepository->find($id);

        if (empty($band)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/bands.singular')])
            );
        }

        return $this->sendResponse(
            new BandResource($band),
            __('messages.retrieved', ['model' => __('models/bands.singular')])
        );
    }

    /**
     * Update the specified Band in storage.
     * PUT/PATCH /bands/{id}
     */
    public function update($id, UpdateBandAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Band $band */
        $band = $this->bandRepository->find($id);

        if (empty($band)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/bands.singular')])
            );
        }

        $band = $this->bandRepository->update($input, $id);

        return $this->sendResponse(
            new BandResource($band),
            __('messages.updated', ['model' => __('models/bands.singular')])
        );
    }

    /**
     * Remove the specified Band from storage.
     * DELETE /bands/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Band $band */
        $band = $this->bandRepository->find($id);

        if (empty($band)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/bands.singular')])
            );
        }

        $band->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/bands.singular')])
        );
    }
}
