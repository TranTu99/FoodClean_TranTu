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
        // Tính tổng doanh thu từ các đơn hàng đã thanh toán (chữ P viết hoa)
        $totalRevenue = \App\Models\Order::where('status', 'Paid')->sum('total_amount');

        // Đếm tổng số đơn hàng
        $totalOrders = \App\Models\Order::count();

        // Đếm tổng số khách hàng (is_admin == 0)
        $totalCustomers = \App\Models\User::where('is_admin', 0)->count();

        // Đếm số sản phẩm hiện có
        $totalProducts = \App\Models\Product::count();
        // Ở đây bạn có thể lấy tổng số user, tổng số sản phẩm, tổng doanh thu,...
        // Hiện tại, chúng ta chỉ cần chuyển hướng đến trang danh sách sản phẩm.

        // Hoặc: return view('admin.dashboard'); // nếu bạn muốn tạo trang tổng quan
        return view('admin.dashboard', compact('totalRevenue', 'totalOrders', 'totalCustomers', 'totalProducts'));
    }
}
