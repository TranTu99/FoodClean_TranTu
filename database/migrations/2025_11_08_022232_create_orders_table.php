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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Thông tin người dùng (Khóa ngoại)
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Thông tin đơn hàng
            $table->string('order_code')->unique(); // Mã đơn hàng tự sinh (ví dụ: HD20251108XXXX)
            $table->dateTime('order_date');
            $table->decimal('total_amount', 10, 2); // Tổng tiền (10 chữ số, 2 chữ số thập phân)
            $table->string('shipping_address');
            $table->string('phone_number');
            $table->string('payment_method');
            $table->string('status')->default('Pending'); // Mặc định là 'Pending'
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
