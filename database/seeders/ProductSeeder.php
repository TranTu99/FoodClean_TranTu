<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use Illuminate\Support\Str;


class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. TẠO CÁC DANH MỤC MỚI (Trứng, Thịt, Gạo) nếu chưa tồn tại
        $newCategoriesToSeed = ['Trứng', 'Thịt', 'Gạo'];

        foreach ($newCategoriesToSeed as $name) {
            Category::firstOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'parentid' => 0,
                    'display' => 1,
                    'stt' => 10,
                ]
            );
        }

        // 2. LẤY ID CỦA TẤT CẢ 5 DANH MỤC (KỂ CẢ CŨ VÀ MỚI)
        $categories = [
            'Hoa Quả Tươi' => Category::where('name', 'Hoa Quả Tươi')->first(),
            'Rau Củ' => Category::where('name', 'Rau Củ')->first(),
            'Trứng' => Category::where('name', 'Trứng')->first(),
            'Thịt' => Category::where('name', 'Thịt')->first(),
            'Gạo' => Category::where('name', 'Gạo')->first(),
        ];


        // 3. CHÈN DỮ LIỆU SẢN PHẨM MẪU VÀ CHI TIẾT
        $productsData = [
            // SẢN PHẨM 1: HOA QUẢ TƯƠI
            [
                'category_id' => $categories['Hoa Quả Tươi']->id,
                'name' => 'Táo Fuji Nhật Bản',
                'description' => 'Táo giòn, ngọt, nhập khẩu từ Nhật Bản.',
                'price' => 150000.00,
                'sale_price' => 135000.00,
                'details' => 'Đóng gói 1kg (4-5 quả). Giàu vitamin C, rất tốt cho sức khỏe.',
            ],
            // SẢN PHẨM 2: RAU CỦ
            [
                'category_id' => $categories['Rau Củ']->id,
                'name' => 'Cà Rốt Đà Lạt Hữu Cơ',
                'description' => 'Cà rốt tươi, sạch, trồng tại Đà Lạt.',
                'price' => 25000.00,
                'sale_price' => null,
                'details' => 'Sản phẩm đạt chuẩn VietGAP. Dùng để ép nước hoặc nấu canh.',
            ],
            // SẢN PHẨM 3: TRỨNG
            [
                'category_id' => $categories['Trứng']->id,
                'name' => 'Trứng Gà Ta Thảo Mộc',
                'description' => 'Trứng gà tươi sạch, giàu dinh dưỡng.',
                'price' => 45000.00,
                'sale_price' => 40000.00,
                'details' => 'Sản phẩm được đóng gói 10 quả/vỉ. Nguồn gốc rõ ràng tại trang trại Thảo Mộc.',
            ],
            // SẢN PHẨM 4: THỊT
            [
                'category_id' => $categories['Thịt']->id,
                'name' => 'Thịt Bò Tơ Phi Lê',
                'description' => 'Thịt bò tơ mềm, tươi ngon, thích hợp làm bít tết.',
                'price' => 250000.00,
                'sale_price' => 230000.00,
                'details' => 'Trọng lượng: 500g/hộp. Cung cấp protein và sắt dồi dào. Bảo quản: Ngăn đông.',
            ],
            // SẢN PHẨM 5: GẠO
            [
                'category_id' => $categories['Gạo']->id,
                'name' => 'Gạo Tám Xoan Hải Hậu',
                'description' => 'Gạo dẻo thơm, nguồn gốc Hải Hậu.',
                'price' => 120000.00,
                'sale_price' => null,
                'details' => 'Đóng gói 5kg/túi. Gạo đạt chuẩn OCOP 4 sao. Cách nấu: 1 chén gạo với 1 chén nước.',
            ],
        ];

        foreach ($productsData as $data) {
            // Tách dữ liệu Sản phẩm chính
            $productData = [
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'price' => $data['price'],
                'sale_price' => $data['sale_price'],
                'image' => 'assets/img/products/' . Str::slug($data['name']) . '.jpg',
            ];

            // TẠO SẢN PHẨM
            $product = Product::create($productData);

            // TẠO CHI TIẾT SẢN PHẨM LIÊN KẾT
            ProductDetail::create([
                'product_id' => $product->id,
                'full_description' => $data['details'],
                'stock_quantity' => rand(10, 100),
            ]);
        }
    }
}
