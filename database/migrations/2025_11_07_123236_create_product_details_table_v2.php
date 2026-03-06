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
        Schema::create('product_details', function (Blueprint $table) {

            // Khóa chính và Khóa Ngoại One-to-One
            // Dùng unsignedBigInteger để khớp với products.id
            $table->unsignedBigInteger('product_id')->primary();

            $table->longText('full_description')->nullable();
            $table->string('technical_specs')->nullable();
            $table->integer('stock_quantity')->default(0);

            // Khai báo Khóa Ngoại
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
