<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\MustVerifyEmail;

class TenantModel extends Model
{
    use HasFactory,MustVerifyEmail;

    protected $table = 'tenants';
}
