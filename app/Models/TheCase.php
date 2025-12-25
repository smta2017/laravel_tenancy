<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class TheCase extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'the_cases';

    public $fillable = [
        'id',
        'name',
        'code',
        'case_number',
        'type',
        'status',
        'subject',
        'court',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'code' => 'string',
        'case_number' => 'string',
        'type' => 'string',
        'status' => 'integer',
        'subject' => 'string',
        'court' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    
}
