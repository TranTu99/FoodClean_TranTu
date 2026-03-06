<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->where('display', 1)->firstOrFail(); //Nếu không tìm thấy bản ghi nào, nó sẽ tự động ném ra ngoại lệ Illuminate\Database\Eloquent\ModelNotFoundException.
        $products = Product::where('category_id', $category->id)
            ->latest() // Sắp xếp sản phẩm mới nhất lên trước
            ->paginate(3);
        $data = [
            'active_menu' => $slug,
            'title' => 'Danh mục: ' . $category->name,
            'subtitle' => 'Tất cả sản phẩm thuộc danh mục ' . $category->name,
            'products' => $products,
        ];
        return view('shop', $data);
    }

    public function StaticHome()
    {
        // Lấy 8 sản phẩm mới nhất để hiển thị
        $products = Product::latest()->take(8)->get();
        // Lấy danh sách danh mục (Menu)
        $categories = Category::where('parentid', 0)->where('display', 1)->orderBy('stt', 'asc')->get();
        $data = [
            'active_menu' => 'home',
            'title' => 'Delicious Seasonal Fruits',
            'subtitle' => 'FRESH & ORGANIC',
            'wrapper_class' => 'hero-area hero-bg',
            'is_slider' => false,
            'products' => $products,
            'categories' => $categories,
        ];
        return view('index', $data);
    }
    public function SliderHome()
    {
        // Lấy 8 sản phẩm mới nhất
        $products = Product::latest()->take(8)->get();
        $categories = Category::where('parentid', 0)->where('display', 1)->orderBy('stt', 'asc')->get();
        $data = [
            'active_menu' => 'home',
            'title' => 'Get December Discount',
            'subtitle' => 'MEGA SALE GOING ON!',
            'wrapper_class' => 'hero-area hero-bg',
            'is_slider' => true,
            'products' => $products,
            'categories' => $categories,
        ];
        return view('sliderhome', $data);
    }
    public function About()
    {
        $data = [
            'active_menu' => 'about',
            'title' => 'About Us',
            'subtitle' => 'We sale fresh fruits',
        ];

        return view('about', $data);
    }
    public function Er()
    {
        $data = [
            'active_menu' => 'er',
            'title' => '404 - Not Found',
            'subtitle' => 'Fresh and Organic',
        ];

        return view('er', $data);
    }
    public function Cart()
    {
        $data = [
            'active_menu' => 'cart',
            'title' => 'Giỏ Hàng',
            'subtitle' => 'Kiểm tra và thanh toán',
        ];
        return view('cart', $data);
    }
    public function Checkout()
    {
        $data = [
            'active_menu' => 'checkout',
            'title' => 'Check Out Product',
            'subtitle' => 'Fresh and Organic',
        ];
        return view('checkout', $data);
    }
    public function Contact()
    {
        $data = [
            'active_menu' => 'contact',
            'title' => 'Contact Us',
            'subtitle' => 'Get 24/7 Support',
        ];
        return view('contact', $data);
    }
    public function New()
    {
        $data = [
            'active_menu' => 'new',
            'title' => 'News Article',
            'subtitle' => 'Organic Information',
        ];
        return view('new', $data);
    }

    public function Shop()
    {
        // Lấy tất cả sản phẩm và phân trang
        $products = Product::latest()->paginate(3);
        $data = [
            'active_menu' => 'shop',
            'title' => 'Shop Sản Phẩm',
            'subtitle' => 'Tất cả sản phẩm',
            'products' => $products,
        ];
        return view('shop', $data);
    }
    // HÀM Singlenew (Chi tiết tin tức)
    public function Singlenew()
    {
        $data = [
            'active_menu' => 'singlenew',
            'title' => 'Single Article',
            'subtitle' => 'Read the Details',
        ];
        return view('singlenew', $data);
    }

    public function Singleproduct()
    {
        // Tạo một đối tượng sản phẩm giả (Product Mockup) ĐẦY ĐỦ THUỘC TÍNH
        $product_placeholder = (object)[
            'id' => 0,
            'name' => 'Bánh Trung Thu Thập Cẩm Cao Cấp',
            'price' => 250000,
            'sale_price' => null,
            'image' => 'assets/img/products/product-img-1.jpg',

            // ✅ THUỘC TÍNH MỚI ĐƯỢC BỔ SUNG ĐỂ KHẮC PHỤC LỖI:
            'description_short' => 'Tóm tắt mẫu: Đây là phần giới thiệu ngắn gọn cho sản phẩm demo.',

            // Các thuộc tính khác (description là nội dung đầy đủ)
            'description' => 'Đây là trang chi tiết sản phẩm mẫu (tĩnh). Biến $product được tạo giả để hiển thị giao diện chi tiết. Nếu còn lỗi Undefined property, vui lòng kiểm tra xem View đang gọi thêm thuộc tính nào khác và thêm vào đây.',
            'slug' => 'banh-trung-thu-mau',
        ];

        // Tạo mảng rỗng cho sản phẩm liên quan (đảm bảo View không lỗi khi lặp)
        $related_products_placeholder = [];

        $data = [
            'active_menu' => 'singleproduct',
            'title' => 'Single Product',
            'subtitle' => 'See more Details',
            'product' => $product_placeholder,
            'related_products' => $related_products_placeholder,
        ];

        return view('singleproduct', $data);
    }
}
