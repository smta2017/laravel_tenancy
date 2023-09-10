<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'name',
        'code',
        'category_id',
        'status_id',
        'brand_id',
        'tax',
        'tax_type',
        'description',
        'type',
        'cost',
        'price',
        'unit_id',
        'sale_unit_id',
        'purchase_unit_id',
        'stok_alert',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Product::class;
    }
}
