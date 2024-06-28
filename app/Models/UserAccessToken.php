<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class UserAccessToken extends SanctumPersonalAccessToken
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.user_access_tokens
     *
     * @var array
     */
    protected $table = 'user_access_tokens';

    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
        'device_id',
    ];
}
