<?php

namespace App\Repositories;

use App\Models\Warehouse;
use App\Repositories\BaseRepository;

class WarehouseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name',
        'phone',
        'country',
        'city',
        'email',
        'zipcode',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Warehouse::class;
    }
}
