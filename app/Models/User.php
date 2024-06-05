<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verification_token',
        'admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'pivot',
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function password(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value,
            set: fn (string $value) => Hash::make($value)
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value)
        );
    }

    /**
     * Determine if the user is Available
     */
    protected function isVerified(): Attribute
    {
        return new Attribute(
            get: fn () =>  $this->verified == User::VERIFIED_USER
        );
    }

    /**
     * Determine if the user is Available
     */
    protected function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () =>  $this->admin == User::ADMIN_USER
        );
    }

    public static function generateVerificationCode()
    {
        return Str::random(40);
    }
}
