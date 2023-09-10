<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Customer extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'customers';

    public $fillable = [
        'name',
        'phone',
        'country',
        'city',
        'email',
        'tax_number',
        'address',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string',
        'phone' => 'string',
        'country' => 'string',
        'city' => 'string',
        'email' => 'string',
        'tax_number' => 'string',
        'address' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    
}
