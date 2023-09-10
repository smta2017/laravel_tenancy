<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Brand extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'brands';

    public $fillable = [
        'img',
        'name',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'img' => 'string',
        'name' => 'string'
    ];

    public static array $rules = [
        'img' => 'required',
        'name' => 'required'
    ];

    
}
