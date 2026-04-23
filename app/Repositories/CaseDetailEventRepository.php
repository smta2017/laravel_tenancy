<?php

namespace App\Repositories;

use App\Models\CaseDetailEvent;
use App\Repositories\BaseRepository;

class CaseDetailEventRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'case_details_id',
        'parent_id',
        'subject',
        'notes',
        'type_id',
        'status_id',
        'created_by',
        'assigned_to',
        'closed_by',
        'is_private',
        'client_access',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return CaseDetailEvent::class;
    }
}
