<?php

namespace App\Repositories;

use App\Models\LitigationAuthorityType;
use App\Repositories\BaseRepository;

class LitigationAuthorityTypeRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return LitigationAuthorityType::class;
    }
}
