<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController; // Import Dashboard Controller
Route::middleware('guest')->group(function () {
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::post('/order/place', [CartController::class, 'placeOrder'])->name('order.place');
    // Route giả định cho Thanh toán VNPAY (sẽ dùng VnpayController sau)
    Route::get('/vnpay/create/{order_id}', function ($order_id) {
        return "Bắt đầu tạo link VNPAY cho đơn hàng: " . $order_id;
    })->name('vnpay.create_payment');
});
Route::get('/', [HomeController::class, 'StaticHome'])->name('home');
Route::get('/statichome', [HomeController::class, 'StaticHome']);
Route::get('/sliderhome', [HomeController::class, 'SliderHome']);
Route::get('/about', [HomeController::class, 'About'])->name('about');
Route::get('/er', [HomeController::class, 'Er'])->name('er');
Route::get('/contact', [HomeController::class, 'Contact'])->name('contact');
Route::get('/new', [HomeController::class, 'New'])->name('new');
Route::get('/shop', [HomeController::class, 'Shop'])->name('shop');
Route::get('/single-news', [HomeController::class, 'Singlenew'])->name('single-news');

Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/search', [ProductController::class, 'search'])->name('search.product');
Route::get('/single-product/{slug}', [ProductController::class, 'singleProductDynamic'])->name('single.product.dynamic');
Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::patch('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeProduct'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    // GET	        /products	        index()	    Đọc (Danh sách)
    // GET	        /products/create	create()	Tạo (Hiển thị Form)
    // POST	        /products	        store()	    Tạo (Lưu dữ liệu mới)
    // GET	        /products/{id}	    show()	    Đọc (Chi tiết 1 sản phẩm)
    // GET	        /products/{id}/edit	edit()	    Cập nhật (Hiển thị Form sửa)
    // PUT/PATCH	/products/{id}	    update()	Cập nhật (Lưu dữ liệu sửa)
    // DELETE	    /products/{id}	    destroy()	Xóa
});
