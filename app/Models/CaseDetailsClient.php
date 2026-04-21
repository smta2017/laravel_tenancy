<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class CaseDetailsClient extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'case_details_clients';

    public $fillable = [
        'id',
        'case_details_id',
        'client_id',
        'attribute_opponent_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        
    ];

    public function caseDetails(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\CaseDetails::class, 'case_details_id', 'id');
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function attributeOpponent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\AttributeOpponent::class, 'attribute_opponent_id', 'id');
    }
}
