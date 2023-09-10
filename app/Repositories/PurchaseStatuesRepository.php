<?php

namespace App\Repositories;

use App\Models\PurchaseStatues;
use App\Repositories\BaseRepository;

class PurchaseStatuesRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
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
        return PurchaseStatues::class;
    }
}
