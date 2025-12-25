<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateCentralUserAPIRequest;
use App\Http\Requests\API\UpdateCentralUserAPIRequest;
use App\Http\Resources\CentralUserResource;
use App\Models\CentralUser;
use App\Repositories\CentralUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class CentralUserAPIController
 */
class CentralUserAPIController extends AppBaseController
{
    /** @var  CentralUserRepository */
    private $centralUserRepository;

    public function __construct(CentralUserRepository $centralUserRepo)
    {
        $this->centralUserRepository = $centralUserRepo;
    }

    /**
     * Display a listing of the CentralUsers.
     * GET|HEAD /central-users
     */
    public function index(Request $request): JsonResponse
    {
        $centralUsers = $this->centralUserRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(
            CentralUserResource::collection($centralUsers),
            'Central Users retrieved successfully'
        );
    }

    /**
     * Store a newly created CentralUser in storage.
     * POST /central-users
     */
    public function store(CreateCentralUserAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        // Generate global_id if not provided
        if (!isset($input['global_id'])) {
            $input['global_id'] = (string) Str::uuid();
        }

        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $centralUser = $this->centralUserRepository->create($input);

        return $this->sendResponse(
            new CentralUserResource($centralUser),
            'Central User saved successfully'
        );
    }

    /**
     * Display the specified CentralUser.
     * GET|HEAD /central-users/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var CentralUser $centralUser */
        $centralUser = $this->centralUserRepository->find($id);

        if (empty($centralUser)) {
            return $this->sendError('Central User not found');
        }

        return $this->sendResponse(
            new CentralUserResource($centralUser),
            'Central User retrieved successfully'
        );
    }

    /**
     * Update the specified CentralUser in storage.
     * PUT/PATCH /central-users/{id}
     */
    public function update($id, UpdateCentralUserAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var CentralUser $centralUser */
        $centralUser = $this->centralUserRepository->find($id);

        if (empty($centralUser)) {
            return $this->sendError('Central User not found');
        }

        if (isset($input['password'])) {
            $input['password'] = bcrypt($input['password']);
        }

        $centralUser = $this->centralUserRepository->update($input, $id);

        return $this->sendResponse(
            new CentralUserResource($centralUser),
            'Central User updated successfully'
        );
    }

    /**
     * Remove the specified CentralUser from storage.
     * DELETE /central-users/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var CentralUser $centralUser */
        $centralUser = $this->centralUserRepository->find($id);

        if (empty($centralUser)) {
            return $this->sendError('Central User not found');
        }

        $centralUser->delete();

        return $this->sendSuccess('Central User deleted successfully');
    }
}
