<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            // Cột ID: int, AUTO_INCREMENT (unsigned)
            $table->unsignedInteger('id')->autoIncrement();

            // Các cột còn lại (tên cột khớp 100% với Model và ảnh DB)
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable()->unique();
            $table->integer('parentid')->nullable(); // Tên cột parentid khớp
            $table->integer('stt')->default(0);
            $table->boolean('display')->nullable()->default(1);

            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
