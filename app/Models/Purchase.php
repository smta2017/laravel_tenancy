<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Purchase extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'purchases';

    public $fillable = [
        'GrandTotal',
        'TaxNet',
        'the_date',
        'discount',
        'notes',
        'shipping',
        'status_id',
        'supplier_id',
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
        'supplier_id' => 'required',
        'warehouse_id' => 'required'
    ];

    public function purchaseDetails(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\PurchaseDetails::class, 'purchase_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\purchase_status_id::class, 'status_id', 'id');
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
