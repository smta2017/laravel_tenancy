<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\BaseRepository;

class SaleRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'grand_total',
        'tax_net',
        'the_date',
        'discount',
        'notes',
        'shipping',
        'status_id',
        'customer_id',
        'warehouse_id',
        'tax_rate',
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
        return Sale::class;
    }
}
