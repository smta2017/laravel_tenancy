<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class Client extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'clients';

    public $fillable = [
        'id',
        'name',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'name' => 'string'
    ];

    public static array $rules = [
        'name' => 'required'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(\App\Models\User::class, 'user_id', 'id');
    }
}
