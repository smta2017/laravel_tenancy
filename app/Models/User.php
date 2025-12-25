<?php

namespace App\Models;

use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Contracts\Syncable;
use Stancl\Tenancy\Database\Concerns\ResourceSyncing;

class User extends Authenticatable implements Syncable
{
    use HasApiTokens, HasFactory, Notifiable, ResourceSyncing, HasRoles;
    protected string $guard_name = 'web';
    protected $guarded = [];
    public $timestamps = false;

    public function getGuardName()
    {
        return 'web';
    }

    public function getGlobalIdentifierKey()
    {
        return $this->getAttribute($this->getGlobalIdentifierKeyName());
    }

    public function getGlobalIdentifierKeyName(): string
    {
        return 'global_id';
    }

    public function getCentralModelName(): string
    {
        return CentralUser::class;
    }

    public function centralUser()
    {
        return CentralUser::where('global_id', $this->global_id)->first();
    }

    public function getSyncedAttributeNames(): array
    {
        return [
            'name',
            'password',
            'email',
        ];
    }

    // ====================================



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'global_id',
        'first_name',
        'last_name',
        'phone',
        'nationalitie_id',
        'd_o_b',
        'job',
        'website',
        'photo',
        'is_active',
        'active_token',
        'is_approved',
        'code',
        'is_admin',
        'is_owner',
        'covenantAccount_id',
        'requestaccount_id',
        'last_login',
        'last_login_location',
        'logout_at',
        'default_language',
        'account_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'account_verified_at' => 'datetime',
    ];

    public static array $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable|string|max:20',
        'job' => 'nullable|string|max:100',
        'website' => 'nullable|url|max:200',
        'd_o_b' => 'nullable|date',
    ];


    public function sendPasswordResetNotification($token)
    {
        $url = url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $this->email], false));
        $this->notify(new CustomResetPasswordNotification($token));
    }
}
