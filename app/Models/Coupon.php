<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    // Khai báo các cột được phép lưu dữ liệu hàng loạt
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_value',
        'expiry_date',
        'usage_limit',
        'used_count',
        'is_active'
    ];
}
