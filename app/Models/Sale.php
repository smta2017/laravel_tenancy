<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sale extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'sales';

    public $fillable = [
        'GrandTotal',
        'TaxNet',
        'the_date',
        'discount',
        'notes',
        'shipping',
        'status_id',
        'customer_id',
        'warehouse_id',
        'tax_rate',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'GrandTotal' => 'double',
        'TaxNet' => 'double',
        'the_date' => 'date',
        'discount' => 'double',
        'notes' => 'string',
        'shipping' => 'double',
        'tax_rate' => 'double'
    ];

    public static array $rules = [
        'the_date' => 'required',
        'status_id' => 'required',
        'customer_id' => 'required',
        'warehouse_id' => 'required'
    ];

    public function saleDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\SaleDetails::class, 'sale_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\SaleStatues::class, 'status_id', 'id');
    }

    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Customer::class, 'customer_id', 'id');
    }

    public function warehouse(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Warehouse::class, 'warehouse_id', 'id');
    }
}
