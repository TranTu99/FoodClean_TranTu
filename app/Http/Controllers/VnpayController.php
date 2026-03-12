<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class VnpayController extends Controller
{
    public function createPayment($order_id)
    {
        $order = Order::findOrFail($order_id);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = config('services.vnpay.return_url');

        $vnp_TxnRef = (string) $order->id;
        $vnp_Amount = (int) round($order->total_amount * 100);

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_Command"    => "pay",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => request()->ip(), // hoặc IPv4 thật của client
            "vnp_Locale"     => "vn",
            "vnp_OrderInfo"  => "Thanh toan don hang " . $vnp_TxnRef,
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            // "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')),
        ];

        ksort($inputData);

        $query = "";
        $hashdata = "";
        $i = 0;

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                $query    .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $query    .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $finalUrl = $vnp_Url . "?" . $query . '&vnp_SecureHash=' . $vnp_SecureHash;

        return redirect()->away($finalUrl);
    }

    public function vnpayReturn(Request $request)
    {
        $orderId = $request->vnp_TxnRef;

        if ($request->vnp_ResponseCode == '00') {
            // 1. Cập nhật trạng thái đơn hàng trong DB
            $updated = DB::table('orders')->where('id', $orderId)->update([
                'status' => 'Paid',
                'updated_at' => now()
            ]);

            if ($updated) {
                // 2. XÓA GIỎ HÀNG TRONG DATABASE (Dành cho User đã đăng nhập)
                // Tìm giỏ hàng của người dùng hiện tại và xóa sạch các món hàng bên trong
                $userId = Auth::id();
                if ($userId) {
                    $cart = \App\Models\Cart::where('user_id', $userId)->first();
                    if ($cart) {
                        $cart->items()->delete(); // Xóa tất cả các mục trong cart_items
                    }
                }

                // 3. Xóa thêm Session nếu bạn có dùng để lưu tạm
                session()->forget('cart');

                return view('vnpay.success', ['orderId' => $orderId]);
            }
        }

        return redirect('/')->with('error', 'Thanh toán thất bại!');
    }
}
