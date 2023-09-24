<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Purchase extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'purchases';

    public $fillable = [
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
        'supplier_id' => 'required',
        'warehouse_id' => 'required',
        // 'created_by' => 'required'
    ];

    public function purchaseDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PurchaseDetails::class, 'purchase_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\PurchaseStatues::class, 'status_id', 'id');
    }

    public function supplier(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Supplier::class, 'supplier_id', 'id');
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
