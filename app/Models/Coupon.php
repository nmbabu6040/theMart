<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_cart_amount',
        'validity',
        'status',
    ];

    // Coupon-ti active ebong valid kina check korar helper
    public function isValid()
    {
        return $this->status == 1 && Carbon::parse($this->validity)->gte(Carbon::today());
    }
}
