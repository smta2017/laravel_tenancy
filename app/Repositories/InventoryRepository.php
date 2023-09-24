<?php

namespace App\Repositories;

use App\Models\Inventory;
use App\Repositories\BaseRepository;

class InventoryRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'id',
        'purchase_id',
        'product_id',
        'supplier_id',
        'warehouse_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Inventory::class;
    }

    public function updateInventory($product, $purchase)
    {
        // Update inventory
        // Check if a record with the same product_id and warehouse_id exists
        $existingInventory = Inventory::whereProductId($product['product_id'])->whereWarehouseId($purchase['warehouse_id'])->first();

        if ($existingInventory) {
            // Update the quantity if the record exists
            $existingInventory->update([
                'quantity' => $existingInventory->quantity + $product['quantity'],
            ]);
        } else {
            // Create a new record if it doesn't exist
            Inventory::create([
                'purchase_id' => $purchase->id,
                'supplier_id' => $purchase->supplier_id,
                'product_id' => $product['product_id'],
                'warehouse_id' => $purchase['warehouse_id'],
                'quantity' => $product['quantity'],
            ]);
        }
        return 'Done';
    }

    function saleOpration($product, $sale)
    {

        $existingInventory = Inventory::whereProductId($product['product_id'])->whereWarehouseId($sale['warehouse_id'])->first();

        if (!$existingInventory->quantity > 0) {
            return false;
        }

        $existingInventory->update([
            'quantity' => $existingInventory->quantity - $product['quantity']
        ]);
    }
}
