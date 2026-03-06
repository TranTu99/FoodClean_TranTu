<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    // Tùy chỉnh cho quan hệ One-to-One: product_id là khóa chính
    public $incrementing = false;
    protected $primaryKey = 'product_id';
    // Đảm bảo kiểu khóa chính khớp (BigInt)
    protected $keyType = 'int';

    protected $fillable = [
        'product_id',
        'full_description',
        'technical_specs',
        'stock_quantity',
    ];

    // Quan hệ ngược lại: Chi tiết thuộc về một Sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
