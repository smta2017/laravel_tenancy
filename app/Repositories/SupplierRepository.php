<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\BaseRepository;

class SupplierRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'name',
        'phone',
        'country',
        'city',
        'email',
        'tax_number',
        'address',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Supplier::class;
    }
}
