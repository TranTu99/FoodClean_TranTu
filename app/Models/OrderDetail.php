<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    // Cột được phép gán dữ liệu hàng loạt
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Mối quan hệ: Chi tiết đơn hàng thuộc về một Đơn hàng
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Mối quan hệ: Chi tiết đơn hàng thuộc về một Sản phẩm (giả định có Model Product)
    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
