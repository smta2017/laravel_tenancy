<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Repositories\BaseRepository;

class ContractRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'amount',
        'subject',
        'location',
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
        return Contract::class;
    }
}
