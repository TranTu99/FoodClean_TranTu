<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // ✅ Cần thiết cho hàm product()
use App\Models\Cart;    // ✅ Cần thiết cho hàm cart()

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Thuộc tính tính tổng tiền cho item
    public function getTotalAttribute()
    {
        // Dùng thuộc tính của Product
        $price = $this->product->sale_price > 0 ? $this->product->sale_price : $this->product->price;
        return $this->quantity * $price;
    }
}
