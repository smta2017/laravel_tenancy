<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Inventory extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'inventories';

    public $fillable = [
        'id',
        'purchase_id',
        'product_id',
        'supplier_id',
        'warehouse_id',
        'quantity',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'quantity' => 'double'
    ];

    public static array $rules = [
        'supplier_id' => 'required',
        'warehouse_id' => 'required'
    ];

    public function purchase(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Purchase::class, 'purchase_id', 'id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'id');
    }

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Warehouse::class, 'warehouse_id', 'id');
    }
}
