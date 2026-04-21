<?php

namespace App\Repositories;

use App\Models\TheCase;
use App\Repositories\BaseRepository;

class TheCaseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'AutoNumber',
        'code',
        'case_number',
        'subject',
        'type_id',
        'status_id',
        'contract_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return TheCase::class;
    }
}
