<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Admin extends Authenticatable
{
    use HasFactory,SoftDeletes,Notifiable,HasApiTokens;

    protected $fillable = [
        'name',
        'username',
        'mobile',
        'password',
        'mobile_verified_at',
        'is_active',
        'avatar'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active'=> 'boolean',
    ];

}
