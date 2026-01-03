<?php

namespace App\Repositories\Central;

use App\Models\CentralUser;
use App\Repositories\BaseRepository;

class CentralUserRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'email',
        'phone',
        'global_id'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CentralUser::class;
    }

    public function tenantUsers()
    {
        return $this->model->whereHas('tenants')->get();
    }

    public function centralUsers()
    {
        return $this->model->whereDoesntHave('tenants')->get();
    }
}
