<?php

namespace App\Repositories;

use App\Models\SaleDetail;
use App\Repositories\BaseRepository;

class SaleDetailRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'sale_id',
        'name',
        'discountNet',
        'discount_Method',
        'discount',
        'net_cost',
        'unit_cost',
        'code',
        'del',
        'no_unit',
        'product_id',
        'purchase_unit_id',
        'quantity',
        'stock',
        'subtotal',
        'tax_type',
        'tax_percent',
        'taxe',
        'unitPurchase',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return SaleDetail::class;
    }
}
