<?php

namespace App\Repositories;

use App\Models\Purchase;
use App\Repositories\BaseRepository;

class PurchaseRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'grand_total',
        'tax_net',
        'the_date',
        'discount',
        'notes',
        'shipping',
        'status_id',
        'supplier_id',
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
        return Purchase::class;
    }
}
