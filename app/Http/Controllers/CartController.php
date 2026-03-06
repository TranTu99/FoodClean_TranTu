<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
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
        // 1. Kiểm tra giỏ hàng và đăng nhập
        $cart = $this->getOrCreateCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect(); // if $cart=null trả về collection rỗng

        if (!Auth::check() || $cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống hoặc bạn chưa đăng nhập.');
        }
        // 2. Tính tổng tiền (Subtotal)
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });
        return view('checkout', compact('cartItems', 'subtotal'));
    }
    // Xác thực dữ liệu, tính toán/kiểm tra giỏ hàng, lưu Order vào CSDL, và xử lý phân luồng thanh toán.
    public function placeOrder(Request $request)
    {
        // 1. Validate dữ liệu nhập vào (Dựa trên tên input trong checkout.blade.php)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:COD,ONLINE', // Chấp nhận COD và ONLINE
        ]);

        $cart = $this->getOrCreateCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();

        // Kiểm tra giỏ hàng lần nữa
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống, không thể đặt hàng.');
        }

        // Tính toán lại tổng tiền để đảm bảo tính chính xác
        $total_amount = $cartItems->sum(function ($item) {
            $price = $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price;
            return $item->quantity * $price;
        });

        // 2. Tạo Đơn hàng (Bảng 'orders')
        $order = Order::create([
            'user_id' => Auth::id(),
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'shipping_address' => $request->address,
            'order_note' => $request->note,
            'total_amount' => $total_amount,
            'payment_method' => $request->payment_method,
            'status' => 'Pending', // Trạng thái ban đầu
        ]);

        // 3. Tạo Chi tiết Đơn hàng (Bảng 'order_details')
        foreach ($cartItems as $item) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->sale_price > 0 ? $item->product->sale_price : $item->product->price,
            ]);
        }

        // 4. Xử lý tùy theo Phương thức Thanh toán
        if ($request->payment_method === 'COD') {
            // Nếu là COD, xóa giỏ hàng và thông báo thành công
            $cart->items()->delete();
            return redirect()->route('home')->with('success', 'Đơn hàng COD của bạn đã được đặt thành công! Mã đơn hàng: #' . $order->id);
        }

        if ($request->payment_method === 'ONLINE') {
            // Nếu là ONLINE, giữ lại giỏ hàng và chuyển hướng sang VNPAY

            // Chuyển hướng sang xử lý thanh toán VNPAY (sẽ làm ở bước tiếp theo)
            // Lưu ý: route 'vnpay.create_payment' cần được định nghĩa trong web.php
            return redirect()->route('vnpay.create_payment', ['order_id' => $order->id]);
        }

        // Trường hợp lỗi chung
        return redirect()->route('checkout')->with('error', 'Lỗi không xác định trong quá trình đặt hàng.');
    }
}
