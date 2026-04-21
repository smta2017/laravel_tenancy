<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class ContractBand extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'contract_bands';

    public $fillable = [
        'id',
        'contract_id',
        'band_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'contract_id' => 'required',
        'band_id' => 'required'
    ];

    public function contract(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Contract::class, 'contract_id', 'id');
    }

    public function band(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Band::class, 'band_id', 'id');
    }
}
