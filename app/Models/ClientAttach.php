<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes; use Illuminate\Database\Eloquent\Factories\HasFactory;
class ClientAttach extends Model
{
     use SoftDeletes;    use HasFactory;    public $table = 'client_attaches';

    public $fillable = [
        'id',
        'client_id',
        'attach_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        
    ];

    public static array $rules = [
        'client_id' => 'required',
        'attach_id' => 'required'
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Client::class, 'client_id', 'id');
    }

    public function attach(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Attach::class, 'attach_id', 'id');
    }
}
