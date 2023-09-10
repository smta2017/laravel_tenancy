<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Status extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'statuses';

    public $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    
}
