<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Hàm loại bỏ dấu tiếng Việt (unaccent) và chuẩn hóa chuỗi.
     * Hỗ trợ tìm kiếm không dấu và linh hoạt.
     * @param string $str
     * @return string
     */
    protected function unaccent($str)
    {
        // 1. Chuyển tất cả về chữ thường
        $str = strtolower($str);

        // 2. Loại bỏ dấu
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        // 3. Thay thế các ký tự không phải chữ, số, hoặc khoảng trắng bằng khoảng trắng
        $str = preg_replace("/[^a-z0-9\s]/", ' ', $str);

        // 4. Thay thế nhiều khoảng trắng thành một khoảng trắng duy nhất và trim
        $str = preg_replace('/\s+/', ' ', $str);
        $str = trim($str);

        return $str;
    }

    /**
     * Phương thức xử lý tìm kiếm đa năng, ƯU TIÊN độ chính xác.
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function search(Request $request)
    {
        // Lấy input 'query' (đã sửa trong header)
        $query = $request->input('query', '');
        $searchLower = strtolower($query);

        // Nếu từ khóa rỗng, không tìm kiếm
        if (empty(trim($query))) {
            $products = (new Product)->newCollection();
        } else {
            $products = Product::select('products.*')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->where(function ($q) use ($searchLower) {

                    // ƯU TIÊN 1: Tên sản phẩm BẮT ĐẦU với từ khóa (Tối ưu kết quả liên quan nhất)
                    $q->where(DB::raw('LOWER(products.name)'), 'LIKE', $searchLower . '%');

                    // ƯU TIÊN 2: Tên sản phẩm CHỨA từ khóa
                    $q->orWhere(DB::raw('LOWER(products.name)'), 'LIKE', '%' . $searchLower . '%');

                    // ƯU TIÊN 3: Tên danh mục CHỨA từ khóa
                    $q->orWhere(DB::raw('LOWER(categories.name)'), 'LIKE', '%' . $searchLower . '%');

                    /* Đã loại bỏ tìm kiếm trên description để tránh nhiễu và kết quả dư thừa */
                })
                // Thêm điều kiện is_active nếu cột đó tồn tại (Nếu không thì bỏ comment)
                // ->where('products.is_active', 1)
                ->paginate(9)
                ->withQueryString();
        }

        // Lấy danh sách danh mục
        $menuItems = Category::all();

        $data = [
            'products' => $products,
            'search_query' => $query, // Giữ lại từ khóa gốc để hiển thị trên UI
            'active_menu' => 'shop',
            'menuItems' => $menuItems,
        ];

        // Dùng view 'shop' để hiển thị kết quả tìm kiếm
        return view('shop', $data);
    }

    /**
     * Hiển thị trang chi tiết sản phẩm dựa trên slug.
     * @param string $slug
     * @return \Illuminate\View\View
     */
    public function singleProductDynamic($slug)
    {
        // 1. Tìm Sản phẩm theo slug
        $product = Product::where('slug', $slug)->firstOrFail();

        // 2. Lấy các Sản phẩm liên quan (cùng danh mục, trừ sản phẩm hiện tại)
        $related_products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(4) // Lấy 4 sản phẩm liên quan
            ->get();

        // Lấy danh sách danh mục (Tạm thời dùng all() để tránh lỗi is_active)
        $menuItems = Category::all();

        // 3. Định nghĩa dữ liệu truyền qua view
        $data = [
            'active_menu' => $product->category->slug ?? 'shop', // Active menu dựa trên danh mục
            'title' => $product->name,
            'subtitle' => 'See more Details',
            'product' => $product, // Sản phẩm chính
            'related_products' => $related_products, // Sản phẩm liên quan
            'menuItems' => $menuItems, // Danh sách menu/danh mục
        ];

        return view('singleproduct', $data);
    }
}
