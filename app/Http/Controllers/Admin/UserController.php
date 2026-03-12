<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Chỉ lấy những người dùng KHÔNG PHẢI là admin (is_admin = 0)
        // Phân trang 10 người mỗi trang
        $customers = User::where('is_admin', 0)->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.users.index', compact('customers'));
    }

    public function show($id)
    {
        // Tìm khách hàng theo ID, nếu không thấy thì báo lỗi 404
        $customer = User::with('orders')->findOrFail($id);

        // Tính tổng chi tiêu của khách này (chỉ tính đơn đã thanh toán)
        $totalSpent = $customer->orders->where('status', 'Paid')->sum('total_amount');

        return view('admin.users.show', compact('customer', 'totalSpent'));
    }

    // Sau này bạn có thể thêm hàm lock/unlock tài khoản tại đây
}
