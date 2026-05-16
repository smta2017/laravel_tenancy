<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class LitigationLevel extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'litigation_levels';

    public $fillable = [
        'id',
        'name',
        'color',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'color' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'color' => 'nullable|string'
    ];

    
}
