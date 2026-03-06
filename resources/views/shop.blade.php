@extends('layouts.main')
@section('noidung')
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Tìm kiếm:</h3>
                            <input type="text" placeholder="Từ khóa">
                            <button type="submit">Search <i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $title = 'Sản phẩm của chúng tôi';
        $subtitle = 'Nông sản hữu cơ tươi ngon';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))

    <div class="product-section mt-150 mb-150">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul>
                            <li class="active" data-filter="*">Tất cả</li>
                            <li data-filter=".strawberry">Dâu</li>
                            <li data-filter=".berry">Việt quất</li>
                            <li data-filter=".lemon">Chanh</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row product-lists">
                @forelse ($products as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('single.product.dynamic', ['slug' => $product->slug]) }}">
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                </a>
                            </div>
                            <h3>{{ $product->name }}</h3>
                            <p class="product-price">
                                <span>Per Kg</span>
                                @if ($product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span
                                        style="text-decoration: line-through; color: #999; font-weight: normal; margin-right: 10px;">
                                        {{ number_format($product->price, 0, ',', '.') }}đ
                                    </span>
                                    {{ number_format($product->sale_price, 0, ',', '.') }}đ
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }}đ
                                @endif
                            </p>
                            <div class="button-group">
                                <a href="{{ route('single.product.dynamic', ['slug' => $product->slug]) }}" class="cart-btn"
                                    style="background-color: #333; margin-right: 10px; padding: 12px 10px;">
                                    <i class="fas fa-info-circle"></i> Chi tiết
                                </a>
                                <form action="{{ route('add.to.cart', ['id' => $product->id]) }}" method="POST"
                                    style="display: inline-block;">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="cart-btn"
                                        style="padding: 12px 10px; border: none; cursor: pointer; color: #fff; background-color: #f28123; border-radius: 50px;">
                                        <i class="fas fa-shopping-cart"></i> Giỏ hàng
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12 text-center">
                        <p>Không có sản phẩm nào để hiển thị.</p>
                    </div>
                @endforelse
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="pagination-wrap">
                        {{ $products->links('vendor.pagination.fruitkha') }}
                    </div>
                </div>
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

        .single-product-item .product-image {
            height: 220px;
            overflow: hidden;
        }

        .single-product-item .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .single-product-item {
            min-height: 480px;
            position: relative;
            padding-bottom: 70px;
        }

        .single-product-item .button-group {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        .single-product-item .button-group form {
            display: inline-block;
        }
    </style>
@endsection
