<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Thêm đoạn này vào để cho phép lưu dữ liệu nhanh
    protected $fillable = [
        'user_id',
        'total_amount',
        'phone_number',      // Đúng theo ảnh
        'shipping_address',  // Đúng theo ảnh
        'note',              // Đúng theo ảnh
        'payment_method',
        'status',
        'payment_status',    // Thêm cột này nếu bạn muốn dùng
    ];

    // Nếu bạn có quan hệ với OrderDetail thì thường nó sẽ nằm ở dưới này
    // Quan hệ với User để lấy tên khách hàng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với OrderDetail để xem chi tiết món hàng đã mua
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
