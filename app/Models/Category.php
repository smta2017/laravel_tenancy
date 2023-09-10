<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Category extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'categories';

    public $fillable = [
        'name',
        'color'
    ];

    protected $casts = [
        'name' => 'string',
        'color' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    
}
