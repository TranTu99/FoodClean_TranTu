<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;


class CouponController extends Controller
{
    public function create()
    {
        return view('admin.coupons.create'); // Trả về cái form vừa làm ở Bước 1
    }
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons',
            'type' => 'required',
            'value' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        // Cách 1: Chỉ lấy các trường hợp lệ (Khuyên dùng)
        $data = $request->only(['code', 'type', 'value', 'min_order_value', 'expiry_date']);
        \App\Models\Coupon::create($data);

        // Cách 2: Lấy hết trừ cái token ra
        // \App\Models\Coupon::create($request->except('_token'));
        return redirect()->route('admin.coupons.index')->with('success', '🎉 Chúc mừng! Mã giảm giá ' . $request->code . ' đã được tạo thành công.');
        return redirect()->route('admin.coupons.index')->with('success', 'Tạo mã thành công!');
    }
    public function index()
    {
        // Lấy tất cả mã giảm giá từ Database, sắp xếp mới nhất lên đầu
        $coupons = \App\Models\Coupon::orderBy('created_at', 'desc')->get();

        // Trả về view index và truyền biến coupons sang
        return view('admin.coupons.index', compact('coupons'));
    }
}
