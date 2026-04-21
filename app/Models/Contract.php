<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Contract extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'contracts';

    public $fillable = [
        'id',
        'name',
        'amount',
        'subject',
        'location',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'amount' => 'decimal:2',
        'subject' => 'string',
        'location' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
