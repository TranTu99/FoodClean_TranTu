<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();

            // Khóa ngoại liên kết với đơn hàng
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // Khóa ngoại liên kết với sản phẩm (giả định bạn có bảng products)
            // Nếu bạn có bảng riêng cho Mooncake, hãy thay bằng mooncake_id
            $table->unsignedBigInteger('product_id');
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            // Chi tiết sản phẩm
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Giá sản phẩm tại thời điểm mua

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
