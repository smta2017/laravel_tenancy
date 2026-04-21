<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Band extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'bands';

    public $fillable = [
        'id',
        'title',
        'subject',
        'created_by',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'title' => 'string',
        'subject' => 'string'
    ];

    public static array $rules = [
        
    ];

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
