<?php

namespace App\Repositories;

use App\Models\CaseDetails;
use App\Repositories\BaseRepository;

class CaseDetailsRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'case_id',
        'litigation_level_id',
        'case_number',
        'circle',
        'floor',
        'hall',
        'secretary',
        'litigation_authority_id',
        'gedge',
        'is_active',
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
        return CaseDetails::class;
    }
}
