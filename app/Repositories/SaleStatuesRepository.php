<?php

namespace App\Repositories;

use App\Models\SaleStatues;
use App\Repositories\BaseRepository;

class SaleStatuesRepository extends BaseRepository
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
        return SaleStatues::class;
    }
}
