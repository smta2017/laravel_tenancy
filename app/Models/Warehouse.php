<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Warehouse extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'warehouses';

    public $fillable = [
        'name',
        'phone',
        'country',
        'city',
        'email',
        'zipcode',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'country' => 'string',
        'city' => 'string',
        'email' => 'string',
        'zipcode' => 'string'
    ];

    public static array $rules = [
        'name' => 'required',
        'phone' => 'required',
        'country' => 'required',
        'city' => 'required',
        'email' => 'required',
        'zipcode' => 'required'
    ];

    
}
