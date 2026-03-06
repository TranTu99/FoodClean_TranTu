<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            try {
                redirect('/')->send();
            } catch (\Throwable $th) {
            }
        }
    }
    public function index()
    {
        $products = Product::with('category')->orderBy('id', 'ASC')->get();
        return view('admin.products.index', compact('products'));
    }
    //use Illuminate\Support\Facades\DB;
    // public function index()
    // {
    //     $products = DB::table('products')->join('categories', 'products.category_id', '=', 'categories.id')
    //         ->select('products.*', 'categories.name as category_name')->orderBy('products.id', 'ASC') ->get();
    //     return view('admin.products.index', ['products' => $products]);
    // }
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        // UPLOAD ẢNH: SỬ DỤNG TÊN FILE GỐC
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // check thuộc tính name trên db
            $originalName = $file->getClientOriginalName(); //lấy tên gốc trên máy
            $filename = time() . '_' . $originalName; //1762779148_thitbo.jpg, time() đảm bảo duy nhất tránh ghi đè lên file ảnh cũ
            $upload_path = 'assets/img/products/';
            $file->move(public_path($upload_path), $filename); // trả về đường dẫn tuyệt đối đến thư mục public
            $data['image'] = $upload_path . $filename;
        }
        Product::create($data); //Lưu vào Database
        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm mới thành công!');
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        if ($request->hasFile('image')) {
            if ($product->image) // Xóa ảnh cũ (nếu có)
            {
                $oldImagePath = public_path($product->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            $file = $request->file('image'); // Upload ảnh mới
            $originalName = $file->getClientOriginalName();
            $filename = time() . '_' . $originalName;
            $upload_path = 'assets/img/products/';
            $file->move(public_path($upload_path), $filename);
            $data['image'] = $upload_path . $filename;
        } else {
            // Giữ nguyên ảnh cũ nếu không có file mới được upload
            $data['image'] = $product->image;
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    public function destroy(Product $product)
    {
        if ($product->image) {
            $imagePath = public_path($product->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Xóa sản phẩm thành công!');
    }
}
