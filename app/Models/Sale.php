<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Sale extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'sales';

    public $fillable = [
        'id',
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

    protected $casts = [
        'grand_total' => 'double',
        'tax_net' => 'double',
        'the_date' => 'date',
        'discount' => 'double',
        'notes' => 'string',
        'shipping' => 'double',
        'tax_rate' => 'double'
    ];

    public static array $rules = [
        'the_date' => 'required',
        'customer_id' => 'required',
        'warehouse_id' => 'required',
        // 'created_by' => 'required'
    ];

    public function saleDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\SaleDetail::class, 'sale_id', 'id');
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

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
