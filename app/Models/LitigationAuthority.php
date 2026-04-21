<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class LitigationAuthority extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'litigation_authorities';

    public $fillable = [
        'id',
        'name',
        'type',
        'location',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'location' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\LitigationAuthorityType::class, 'type', 'id');
    }
}
