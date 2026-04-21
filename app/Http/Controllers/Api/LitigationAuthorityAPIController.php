<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateLitigationAuthorityAPIRequest;
use App\Http\Requests\API\UpdateLitigationAuthorityAPIRequest;
use App\Models\LitigationAuthority;
use App\Repositories\LitigationAuthorityRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\LitigationAuthorityResource;

/**
 * Class LitigationAuthorityAPIController
 */
class LitigationAuthorityAPIController extends AppBaseController
{
    /** @var  LitigationAuthorityRepository */
    private $litigationAuthorityRepository;

    public function __construct(LitigationAuthorityRepository $litigationAuthorityRepo)
    {
        $this->litigationAuthorityRepository = $litigationAuthorityRepo;
    }

    /**
     * Display a listing of the LitigationAuthorities.
     * GET|HEAD /litigation-authorities
     */
    public function index(Request $request): JsonResponse
    {
        $litigationAuthorities = $this->litigationAuthorityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            LitigationAuthorityResource::collection($litigationAuthorities),
            __('messages.retrieved', ['model' => __('models/litigationAuthorities.plural')])
        );
    }

    /**
     * Store a newly created LitigationAuthority in storage.
     * POST /litigation-authorities
     */
    public function store(CreateLitigationAuthorityAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $litigationAuthority = $this->litigationAuthorityRepository->create($input);

        return $this->sendResponse(
            new LitigationAuthorityResource($litigationAuthority),
            __('messages.saved', ['model' => __('models/litigationAuthorities.singular')])
        );
    }

    /**
     * Display the specified LitigationAuthority.
     * GET|HEAD /litigation-authorities/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var LitigationAuthority $litigationAuthority */
        $litigationAuthority = $this->litigationAuthorityRepository->find($id);

        if (empty($litigationAuthority)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorities.singular')])
            );
        }

        return $this->sendResponse(
            new LitigationAuthorityResource($litigationAuthority),
            __('messages.retrieved', ['model' => __('models/litigationAuthorities.singular')])
        );
    }

    /**
     * Update the specified LitigationAuthority in storage.
     * PUT/PATCH /litigation-authorities/{id}
     */
    public function update($id, UpdateLitigationAuthorityAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var LitigationAuthority $litigationAuthority */
        $litigationAuthority = $this->litigationAuthorityRepository->find($id);

        if (empty($litigationAuthority)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorities.singular')])
            );
        }

        $litigationAuthority = $this->litigationAuthorityRepository->update($input, $id);

        return $this->sendResponse(
            new LitigationAuthorityResource($litigationAuthority),
            __('messages.updated', ['model' => __('models/litigationAuthorities.singular')])
        );
    }

    /**
     * Remove the specified LitigationAuthority from storage.
     * DELETE /litigation-authorities/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var LitigationAuthority $litigationAuthority */
        $litigationAuthority = $this->litigationAuthorityRepository->find($id);

        if (empty($litigationAuthority)) {
            return $this->sendError(
                __('messages.not_found', ['model' => __('models/litigationAuthorities.singular')])
            );
        }

        $litigationAuthority->delete();

        return $this->sendResponse(
            $id,
            __('messages.deleted', ['model' => __('models/litigationAuthorities.singular')])
        );
    }
}
