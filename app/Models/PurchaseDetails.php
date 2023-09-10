<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class PurchaseDetails extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'purchase_details';

    public $fillable = [
        'purchase_id',
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

    protected $casts = [
        'name' => 'string',
        'discountNet' => 'double',
        'discount_Method' => 'double',
        'discount' => 'double',
        'net_cost' => 'double',
        'unit_cost' => 'double',
        'code' => 'string',
        'del' => 'double',
        'no_unit' => 'integer',
        'quantity' => 'double',
        'stock' => 'double',
        'subtotal' => 'double',
        'tax_type' => 'string',
        'tax_percent' => 'integer',
        'taxe' => 'double',
        'unitPurchase' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    public function purchase(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Purchase::class, 'purchase_id', 'id');
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id', 'id');
    }

    public function purchaseUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Unit::class, 'purchase_unit_id', 'id');
    }
}
