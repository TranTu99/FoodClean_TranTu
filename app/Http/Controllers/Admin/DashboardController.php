<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Hàm __construct() bảo vệ Controller (Chỉ admin mới vào được).
     */
    public function __construct()
    {
        // LOGIC BẢO VỆ ĐƠN GIẢN
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            try {
                redirect('/')->send();
            } catch (\Throwable $th) {
            }
        }
    }

    /**
     * Hiển thị trang Admin Dashboard.
     */
    public function index()
    {
        // Ở đây bạn có thể lấy tổng số user, tổng số sản phẩm, tổng doanh thu,...
        // Hiện tại, chúng ta chỉ cần chuyển hướng đến trang danh sách sản phẩm.

        // Hoặc: return view('admin.dashboard'); // nếu bạn muốn tạo trang tổng quan
        return redirect()->route('admin.products.index'); // Chuyển hướng về trang quản lý sản phẩm
    }
}
