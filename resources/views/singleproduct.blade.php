@extends('layouts.main')
{{-- kế thừa để dùng giao diện --}}
{{-- dùng content --}}
@section('noidung')
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Search For:</h3>
                            <input type="text" placeholder="Keywords">
                            <button type="submit">Search <i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        // Thiết lập title và subtitle cho Hero Banner
        $title = $product->name ?? 'Chi tiết sản phẩm';
        $subtitle = 'Thông tin sản phẩm nông sản hữu cơ';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))

    {{-- Hiển thị thông báo (nếu có) --}}
    @if (session('success'))
        <div class="alert alert-success text-center" style="margin-top: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger text-center" style="margin-top: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="single-product mt-150 mb-150">
        <div class="container">
            <div class="row">
                {{-- CỘT TRÁI: ẢNH SẢN PHẨM --}}
                <div class="col-md-5">
                    <div class="single-product-img">
                        {{-- 💡 ẢNH SẢN PHẨM ĐỘNG --}}
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                {{-- CỘT PHẢI: THÔNG TIN SẢN PHẨM --}}
                <div class="col-md-7">
                    <div class="single-product-content">
                        {{-- 💡 TÊN SẢN PHẨM ĐỘNG --}}
                        <h3>{{ $product->name }}</h3>

                        {{-- 💡 GIÁ SẢN PHẨM ĐỘNG (Dùng logic price/sale_price) --}}
                        <p class="single-product-pricing">
                            <span>Per Kg</span>
                            @if (isset($product->sale_price) && $product->sale_price > 0 && $product->sale_price < $product->price)
                                <del style="color: #999; margin-right: 10px;">
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                </del>
                                <strong>{{ number_format($product->sale_price, 0, ',', '.') }}đ</strong>
                            @else
                                <strong>{{ number_format($product->price, 0, ',', '.') }}đ</strong>
                            @endif
                        </p>

                        {{-- 💡 MÔ TẢ NGẮN ĐỘNG --}}
                        <p>{{ $product->description_short }}</p>

                        <div class="single-product-form">
                            {{-- ✅ FORM THÊM VÀO GIỎ HÀNG (ĐÃ CHẮC CHẮN SỬ DỤNG FORM POST) --}}
                            <form action="{{ route('add.to.cart', ['id' => $product->id]) }}" method="POST">
                                @csrf
                                {{-- Input số lượng phải có name="quantity" --}}
                                <input type="number" placeholder="1" value="1" min="1" name="quantity"
                                    style="width: 100px;">
                                <button type="submit" class="cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào Giỏ
                                </button>
                            </form>

                            {{-- 💡 DANH MỤC ĐỘNG (Kiểm tra xem product có quan hệ category không) --}}
                            <p><strong>Danh mục: </strong>
                                @if (isset($product->category->name))
                                    {{ $product->category->name }}
                                @else
                                    Chưa phân loại
                                @endif
                            </p>
                        </div>

                        {{-- PHẦN CHIA SẺ --}}
                        <h4>Share:</h4>
                        <ul class="product-share">
                            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- 💡 MÔ TẢ CHI TIẾT DÀI (Bổ sung) --}}
            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="single-product-details">
                        <h4>Thông tin chi tiết</h4>
                        <div>
                            {{-- Sử dụng {!! !!} để hiển thị nội dung HTML --}}
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KHỐI SẢN PHẨM LIÊN QUAN --}}
    <div class="more-products mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Sản Phẩm</span> Liên Quan</h3>
                        <p>Các sản phẩm tương tự có thể bạn quan tâm.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- 💡 LẶP QUA SẢN PHẨM LIÊN QUAN ĐỘNG --}}
                @forelse ($related_products as $related)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                {{-- ✅ Liên kết đúng đến chi tiết sản phẩm động --}}
                                <a href="{{ route('single.product.dynamic', ['slug' => $related->slug]) }}">
                                    <img src="{{ asset($related->image) }}" alt="{{ $related->name }}">
                                </a>
                            </div>
                            <h3>{{ $related->name }}</h3>
                            <p class="product-price">
                                <span>Per Kg</span>
                                @if (isset($related->sale_price) && $related->sale_price > 0 && $related->sale_price < $related->price)
                                    <del style="color: #999; margin-right: 5px; font-size: 0.9em;">
                                        {{ number_format($related->price) }}đ
                                    </del>
                                    {{ number_format($related->sale_price) }}đ
                                @else
                                    {{ number_format($related->price) }}đ
                                @endif
                            </p>

                            {{-- 💡 THÊM NÚT GIỎ HÀNG SẢN PHẨM LIÊN QUAN --}}
                            <form action="{{ route('add.to.cart', ['id' => $related->id]) }}" method="POST"
                                style="display: inline-block;">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="cart-btn" style="border: none; cursor: pointer;">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào Giỏ
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 text-center">
                        <p>Không có sản phẩm liên quan nào trong danh mục này.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="logo-carousel-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/1.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/2.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/3.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/4.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/5.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        /* CSS Phân trang (Giữ nguyên) */
        .pagination-wrap ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: inline-block;
        }

        .pagination-wrap ul li {
            display: inline-block;
            margin: 0 5px;
        }

        .pagination-wrap ul li a,
        .pagination-wrap ul li span {
            display: block;
            padding: 8px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            color: #333;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .pagination-wrap ul li.active a,
        .pagination-wrap ul li.active span {
            background-color: #f28123;
            color: white;
            border-color: #f28123;
        }

        .pagination-wrap ul li.disabled span {
            color: #ccc;
            cursor: not-allowed;
        }

        .pagination-wrap ul li a:hover {
            background-color: #f28123;
            color: white;
        }

        /* --- TỐI ƯU BỐ CỤC ẢNH SẢN PHẨM --- */
        .single-product-item .product-image {
            height: 220px;
            /* Chiều cao cố định cho ảnh */
            overflow: hidden;
        }

        .single-product-item .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Đảm bảo ảnh lấp đầy khung */
            object-position: center;
        }

        /* --- CSS CĂN CHỈNH BỐ CỤC THẲNG HÀNG (QUAN TRỌNG) --- */
        .single-product-item {
            min-height: 480px;
            /* Đặt chiều cao tối thiểu cho toàn bộ khối sản phẩm để đảm bảo đồng nhất */
            position: relative;
            /* Quan trọng: Cho phép button-group căn chỉnh tuyệt đối theo nó */
            padding-bottom: 70px;
            /* Khoảng đệm để nội dung không che button-group */
        }

        /* 2. Căn chỉnh nhóm nút (button-group) xuống đáy */
        .single-product-item .button-group {
            position: absolute;
            /* Vị trí tuyệt đối */
            bottom: 20px;
            /* Cách đáy khối cha 20px */
            left: 50%;
            transform: translateX(-50%);
            /* Căn giữa theo chiều ngang */
            white-space: nowrap;
        }

        /* Đảm bảo các form/link trong button-group nằm cạnh nhau */
        .single-product-item .button-group form {
            display: inline-block;
        }
    </style>
@endsection
