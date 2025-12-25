<?php

namespace App\Repositories;

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
}
