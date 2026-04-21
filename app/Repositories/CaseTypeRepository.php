<?php

namespace App\Repositories;

use App\Models\CaseType;
use App\Repositories\BaseRepository;

class CaseTypeRepository extends BaseRepository
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
        return CaseType::class;
    }
}
