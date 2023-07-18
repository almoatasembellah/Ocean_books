<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position',
        'is_admin',
    ];

    public function is_admin()
    {
        return $this->is_admin;
    }

    public function tokens()
    {
        return $this->hasMany(PersonalAccessToken::class);
    }
}
