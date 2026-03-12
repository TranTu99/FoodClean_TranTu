<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã giảm giá (ví dụ: FRUIT20)
            $table->enum('type', ['fixed', 'percent']); // Loại: Tiền mặt hoặc Phần trăm
            $table->decimal('value', 10, 2); // Giá trị giảm (ví dụ: 50000 hoặc 10)
            $table->decimal('min_order_value', 10, 2)->default(0); // Đơn tối thiểu để áp dụng
            $table->date('expiry_date')->nullable(); // Ngày hết hạn
            $table->integer('usage_limit')->nullable(); // Giới hạn số lần dùng (ví dụ: 100 lượt)
            $table->integer('used_count')->default(0); // Số lượt đã dùng thực tế
            $table->boolean('is_active')->default(true); // Trạng thái kích hoạt
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
