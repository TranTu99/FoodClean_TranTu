<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'image',
        'description',
        'price',
        'sale_price',
        'status',
    ];

    // Quan hệ 1-n: Sản phẩm thuộc về Danh mục
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Quan hệ One-to-One: Sản phẩm có một Chi tiết
    public function detail()
    {
        return $this->hasOne(ProductDetail::class);
    }
}
