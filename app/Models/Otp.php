<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Otp extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'user_id',
        'expire_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
