<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'price',
        'product_id',
        'is_active',
        'user_type_id'

    ];

    protected $casts = [
        'is_active'=> 'boolean',
    ];


    public function product(): BelongsTo{
        return $this->belongsTo(Product::class);
    }

    public function userTypes(): BelongsTo{
        return $this->belongsTo(UserType::class,'user_type_id','id');
    }



}
