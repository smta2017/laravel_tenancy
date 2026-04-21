<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class TheCase extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'the_cases';

    public $fillable = [
        'id',
        'AutoNumber',
        'code',
        'case_number',
        'subject',
        'type_id',
        'status_id',
        'contract_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'AutoNumber' => 'string',
        'code' => 'string',
        'case_number' => 'string',
        'subject' => 'string'
    ];

    public static array $rules = [
        'AutoNumber' => 'required',
        'contract_id' => 'required'
    ];

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CaseType::class, 'type_id', 'id');
    }

    public function status(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CaseState::class, 'status_id', 'id');
    }

    public function contract(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Contract::class, 'contract_id', 'id');
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
