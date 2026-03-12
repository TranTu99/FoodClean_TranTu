<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    // Lấy Giỏ hàng hiện có hoặc Tạo mới một Giỏ hàng
    protected function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }
        return null;
    }
    public function addToCart(Request $request, $product_id)
    {
        $cart = $this->getOrCreateCart();
        if (!$cart) {
            return redirect()->route('customer.login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.');
        }
        $quantity = max(1, (int)$request->input('quantity', 1));
        $item = $cart->items()->where('product_id', $product_id)->first(); //kiểm tra xem sản phẩm đang được thêm vào giỏ hàng đã tồn tại chưa
        if ($item) {
            $item->quantity += $quantity;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product_id,
                'quantity' => $quantity,
            ]);
        }
        $product = Product::findOrFail($product_id); //tìm bản ghi sản phẩm có khóa chính (id) khớp với $product_id
        return back()->with('success', 'Đã thêm sản phẩm "' . $product->name . '" vào giỏ hàng!');
    }
    public function index()
    {
        $cart = $this->getOrCreateCart();
        if (!$cart) {
            return redirect()->route('customer.login')->with('info', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }
        $cartItems = $cart->items()->with('product')->get(); //danh sách tất cả các mục trong giỏ hàng.
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });
        return view('cart', compact('cartItems', 'subtotal'));
    }

    public function updateCart(Request $request)
    {
        $cart = $this->getOrCreateCart();
        // has() check dữ liệu gởi lên từ form
        if ($cart && $request->has('quantities')) {
            foreach ($request->input('quantities') as $productId => $quantity) {
                $item = $cart->items()->where('product_id', $productId)->first();
                if ($item && $quantity > 0) {
                    $item->quantity = max(1, (int)$quantity);
                    $item->save();
                }
            }
            return redirect()->back()->with('success', 'Giỏ hàng đã được cập nhật thành công!');
        }

        if ($cart && $request->has('product_id') && $request->has('quantity')) {
            $item = $cart->items()->where('product_id', $request->product_id)->first();
            if ($item && $request->quantity > 0) {
                $item->quantity = max(1, (int)$request->quantity);
                $item->save();
                return response()->json(['success' => true]);
            }
        }
        return redirect()->back()->with('error', 'Lỗi cập nhật giỏ hàng.');
    }
    public function removeProduct($product_id)
    {
        $cart = $this->getOrCreateCart();
        if ($cart) {
            $cart->items()->where('product_id', $product_id)->delete();
            return back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
        }
        return back()->with('error', 'Lỗi xóa sản phẩm khỏi giỏ hàng.');
    }
    public static function countCartItems()
    {
        if (Auth::check()) {
            $cart = Cart::where('user_id', Auth::id())->first();
            return $cart ? $cart->items->sum('quantity') : 0;
        }
        return 0;
    }

    public function checkout()
    {
        $cart = $this->getOrCreateCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();

        if (!Auth::check() || $cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });

        // LẤY GIÁ TRỊ GIẢM GIÁ TỪ SESSION (NẾU CÓ)
        $discount = session()->has('coupon') ? session('coupon')['discount'] : 0;
        $total_amount = $subtotal - $discount;
        if ($total_amount < 0) $total_amount = 0;

        // Truyền thêm biến $discount và $total_amount sang View
        return view('checkout', compact('cartItems', 'subtotal', 'discount', 'total_amount'));
    }
    // Xác thực dữ liệu, tính toán/kiểm tra giỏ hàng, lưu Order vào CSDL, và xử lý phân luồng thanh toán.
    public function placeOrder(Request $request)
    {
        // 1. Validate dữ liệu nhập vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:COD,ONLINE',
        ]);

        $cart = $this->getOrCreateCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();

        // Kiểm tra giỏ hàng lần nữa
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống, không thể đặt hàng.');
        }

        // 2. Tính toán số tiền
        // Tính tổng tiền sản phẩm (Subtotal)
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });

        // Lấy giá trị giảm giá từ Session (nếu có)
        $discount = 0;
        $coupon_id = null;
        if (session()->has('coupon')) {
            $discount = session('coupon')['discount'];
            $coupon_id = session('coupon')['id']; // Lưu lại ID để sau này làm báo cáo nếu cần
        }

        // Tổng tiền cuối cùng sau khi trừ giảm giá
        $total_final = $subtotal - $discount;
        if ($total_final < 0) $total_final = 0;

        // 3. Tạo Đơn hàng (Bảng 'orders')
        $order = new Order();
        $order->user_id          = Auth::id();
        $order->total_amount     = $total_final; // LƯU SỐ TIỀN ĐÃ GIẢM
        $order->phone_number     = $request->phone;
        $order->shipping_address = $request->address;
        $order->note             = "Tên khách: " . $request->name . " (Giảm giá: " . number_format($discount) . "đ)";
        $order->payment_method   = $request->payment_method;
        $order->status           = 'pending';
        $order->payment_status   = 'pending_payment';

        // Nếu bảng orders của bạn có cột coupon_id, hãy lưu vào:
        // $order->coupon_id     = $coupon_id;

        if (!$order->save()) {
            return back()->with('error', 'Lỗi: Không thể lưu đơn hàng vào Database.');
        }

        // 4. Tạo Chi tiết Đơn hàng (OrderDetail)
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price,
            ]);
        }

        // 5. Dọn dẹp: Xóa giỏ hàng và Xóa mã giảm giá trong Session
        $cart->items()->delete();
        session()->forget('coupon'); // Quan trọng: Đã dùng rồi thì phải xóa mã

        // 6. Xử lý Thanh toán
        $paymentMethod = trim($request->payment_method);

        if ($paymentMethod === 'ONLINE' || $paymentMethod === 'TRỰC TUYẾN') {
            // Nếu thanh toán VNPay, truyền order_id đi
            return redirect()->route('vnpay.create_payment', ['order_id' => $order->id]);
        }

        // Mặc định là COD
        return redirect()->route('home')->with('success', 'Đơn hàng của bạn đã được đặt thành công! Mã đơn hàng: #' . $order->id);
    }

    public function applyCoupon(Request $request)
    {
        $couponCode = $request->coupon_code;

        // 1. Tìm mã trong DB
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', 1)
            ->where('expiry_date', '>=', now())
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Mã giảm giá không tồn tại hoặc đã hết hạn!');
        }

        // 2. LẤY GIỎ HÀNG TỪ DATABASE (Thay vì Session)
        $cart = $this->getOrCreateCart();
        if (!$cart) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để sử dụng mã giảm giá.');
        }

        $cartItems = $cart->items()->with('product')->get();

        // Tính tổng tiền từ Database
        $total = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });

        // 3. Kiểm tra điều kiện đơn hàng tối thiểu
        if ($total < $coupon->min_order_value) {
            return redirect()->back()->with('error', 'Đơn hàng của bạn chưa đủ ' . number_format($coupon->min_order_value, 0, ',', '.') . '₫ để dùng mã này.');
        }

        // 4. Tính số tiền được giảm
        $discount = 0;
        if ($coupon->type == 'fixed') {
            $discount = $coupon->value;
        } else {
            $discount = ($total * $coupon->value) / 100;
        }

        // Không cho phép giảm quá tổng tiền đơn hàng
        if ($discount > $total) {
            $discount = $total;
        }

        // 5. Lưu thông tin giảm giá vào Session (Chỉ dùng Session để lưu kết quả giảm giá)
        session()->put('coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'id' => $coupon->id
        ]);

        return redirect()->back()->with('success', 'Đã áp dụng mã giảm giá thành công!');
    }

    // Hàm để khách xóa mã nếu không muốn dùng nữa
    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã xóa mã giảm giá.');
    }
}
