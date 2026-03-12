<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\DashboardController; // Import Dashboard Controller
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\Admin\CouponController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('customer.register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
});
Route::get('/vnpay-return', [VnpayController::class, 'vnpayReturn'])->name('vnpay.return');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::post('/order/place', [CartController::class, 'placeOrder'])->name('order.place');
    Route::get('/vnpay/create/{order_id}', [VnpayController::class, 'createPayment'])->name('vnpay.create_payment');
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
// Route dành cho khách hàng ở trang giỏ hàng
Route::post('/apply-coupon', [App\Http\Controllers\CartController::class, 'applyCoupon'])->name('coupon.apply');
Route::get('/remove-coupon', [App\Http\Controllers\CartController::class, 'removeCoupon'])->name('coupon.remove');
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
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::get('/coupons/create', [CouponController::class, 'create'])->name('coupons.create');
    Route::post('/coupons/store', [CouponController::class, 'store'])->name('coupons.store');
    Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
    // Route để xuất báo cáo
    Route::get('/admin/export-orders', [App\Http\Controllers\Admin\OrderController::class, 'exportOrders'])->name('orders.export');
});
