<?php

namespace App\Repositories;

use App\Models\CaseState;
use App\Repositories\BaseRepository;

class CaseStateRepository extends BaseRepository
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
        return CaseState::class;
    }
}
