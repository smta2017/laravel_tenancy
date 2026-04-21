<?php

namespace App\Repositories;

use App\Models\LitigationAuthority;
use App\Repositories\BaseRepository;

class LitigationAuthorityRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'type',
        'location',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return LitigationAuthority::class;
    }
}
