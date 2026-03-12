<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Lấy danh sách đơn hàng mới nhất kèm thông tin người dùng
        $orders = Order::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $id);
    }
    public function exportOrders()
    {
        // 1. Lấy dữ liệu đơn hàng kèm thông tin khách hàng
        $orders = \App\Models\Order::with('user')->orderBy('created_at', 'desc')->get();

        // 2. Đặt tên file (ví dụ: bao-cao-don-hang-09-03-2026.csv)
        $fileName = 'bao-cao-don-hang-' . date('d-m-Y') . '.csv';

        // 3. Cấu hình Header để trình duyệt hiểu đây là file tải về
        $headers = array(
            "Content-type"        => "text/csv; charset=utf-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        // 4. Tạo luồng ghi dữ liệu (Stream)
        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Thêm mã BOM để Excel mở lên không bị lỗi font tiếng Việt (Quan trọng!)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Tạo dòng tiêu đề cho file
            fputcsv($file, ['Mã đơn', 'Khách hàng', 'Số điện thoại', 'Tổng tiền', 'Phương thức', 'Trạng thái', 'Ngày đặt']);

            // Duyệt qua từng đơn hàng để ghi dòng dữ liệu
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->user ? $order->user->name : 'Khách vãng lai',
                    $order->phone_number,
                    number_format($order->total_amount) . ' VND',
                    $order->payment_method,
                    $order->status, // Ví dụ: pending, paid...
                    $order->created_at->format('d/m/Y H:i')
                ]);
            }
            fclose($file);
        };

        // 5. Trả về phản hồi dạng Stream
        return response()->stream($callback, 200, $headers);
    }
}
