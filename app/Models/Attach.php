<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Attach extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'attaches';

    public $fillable = [
        'id',
        'name',
        'type',
        'path',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'type' => 'string',
        'path' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'type' => 'required',
        'path' => 'required'
    ];

    
}
