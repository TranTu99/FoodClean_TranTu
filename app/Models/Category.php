<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Cột 'id' sẽ được tạo tự động
    protected $fillable = [
        'name',
        'slug',
        'parentid', // ĐÃ SỬA: Dùng 'parentid' để khớp với tên cột trong DB
        'display',
        'stt',
    ];
}
