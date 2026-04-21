<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class CaseDetails extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'case_details';

    public $fillable = [
        'id',
        'case_id',
        'litigation_level_id',
        'case_number',
        'circle',
        'floor',
        'hall',
        'secretary',
        'litigation_authority_id',
        'gedge',
        'is_active',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'case_number' => 'string',
        'circle' => 'string',
        'floor' => 'string',
        'hall' => 'string',
        'secretary' => 'string',
        'gedge' => 'string',
        'is_active' => 'boolean'
    ];

    public static array $rules = [
        
    ];

    public function case(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\TheCase::class, 'case_id', 'id');
    }

    public function litigationLevel(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\LitigationLevel::class, 'litigation_level_id', 'id');
    }

    public function litigationAuthority(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\LitigationAuthority::class, 'litigation_authority_id', 'id');
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
