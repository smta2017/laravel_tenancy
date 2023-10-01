<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Product extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'products';

    public $fillable = [
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
        'has_serial',
        'not_for_sale',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'tax' => 'double',
        'tax_type' => 'string',
        'description' => 'string',
        'type' => 'string',
        'cost' => 'double',
        'price' => 'double',
        'stok_alert' => 'integer',
        'has_serial' => 'boolean',
        'not_for_sale' => 'boolean'
    ];

    public static array $rules = [
        'name' => 'required',
        'category_id' => 'required',
        'status_id' => 'required',
        'brand_id' => 'required',
        'unit_id' => 'required'
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Status::class, 'status_id', 'id');
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id', 'id');
    }

    public function unit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Unit::class, 'unit_id', 'id');
    }

    public function saleUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Unit::class, 'sale_unit_id', 'id');
    }

    public function purchaseUnit(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Unit::class, 'purchase_unit_id', 'id');
    }

    public function Inventories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Inventory::class);
    }
}
