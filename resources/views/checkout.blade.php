@extends('layouts.main')

@section('noidung')
    {{-- Search Area (Nếu có) --}}
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

    {{-- Hero Banner --}}
    @php
        $title = 'Thanh toán';
        $subtitle = 'Hoàn tất đơn hàng';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))

    {{-- Checkout Section --}}
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                {{-- Hiển thị thông báo (thành công/lỗi) --}}
                @if (session('success'))
                    <div class="col-lg-12 mb-4">
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    </div>
                @endif
                @if (session('error'))
                    <div class="col-lg-12 mb-4">
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    </div>
                @endif

                {{-- FORM ĐẶT HÀNG --}}
                <form action="{{ route('order.place') }}" method="POST" class="col-lg-12">
                    @csrf
                    <div class="row">

                        {{-- Cột 1: Thông tin Khách hàng & Thanh toán --}}
                        <div class="col-lg-8">
                            <div class="checkout-accordion-wrap">
                                <div class="accordion" id="accordionExample">

                                    {{-- 1. Thông tin Khách hàng --}}
                                    <div class="card single-accordion">
                                        <div class="card-header" id="headingOne">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                    data-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    Thông tin Khách hàng
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="billing-address-form">
                                                    {{-- Họ tên (Lấy từ Auth nếu có) --}}
                                                    <p>
                                                        <input type="text" name="name" placeholder="Họ tên"
                                                            value="{{ old('name', Auth::user()->name ?? '') }}" required>
                                                        @error('name')
                                                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </p>

                                                    {{-- Email (Lấy từ Auth nếu có) --}}
                                                    <p>
                                                        <input type="email" name="email" placeholder="Email"
                                                            value="{{ old('email', Auth::user()->email ?? '') }}" required>
                                                        @error('email')
                                                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </p>

                                                    {{-- Số điện thoại --}}
                                                    <p>
                                                        <input type="tel" name="phone" placeholder="Số điện thoại"
                                                            value="{{ old('phone') }}" required>
                                                        @error('phone')
                                                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </p>

                                                    {{-- Địa chỉ giao hàng --}}
                                                    <p>
                                                        <input type="text" name="address" placeholder="Địa chỉ giao hàng"
                                                            value="{{ old('address') }}" required>
                                                        @error('address')
                                                            <span class="text-danger d-block mt-1">{{ $message }}</span>
                                                        @enderror
                                                    </p>

                                                    {{-- Ghi chú --}}
                                                    <p>
                                                        <textarea name="note" id="note" cols="30" rows="5" placeholder="Ghi chú về đơn hàng (tùy chọn)">{{ old('note') }}</textarea>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 2. Phương thức Thanh toán --}}
                                    <div class="card single-accordion">
                                        <div class="card-header" id="headingThree">
                                            <h5 class="mb-0">
                                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                                    data-target="#collapseThree" aria-expanded="false"
                                                    aria-controls="collapseThree">
                                                    Phương thức Thanh toán
                                                </button>
                                            </h5>
                                        </div>
                                        <div id="collapseThree" class="collapse show" aria-labelledby="headingThree"
                                            data-parent="#accordionExample">
                                            <div class="card-body">
                                                <div class="card-details">
                                                    <p>
                                                        <input type="radio" id="cod" name="payment_method"
                                                            value="COD" checked>
                                                        <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                                                    </p>
                                                    <p>
                                                        <input type="radio" id="online" name="payment_method"
                                                            value="ONLINE">
                                                        <label for="online">Thanh toán Online (VNPAY/Momo)</label>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- Cột 2: Chi tiết Đơn hàng & Tổng tiền --}}
                        <div class="col-lg-4">
                            <div class="order-details-wrap">
                                <table class="order-details">
                                    <thead>
                                        <tr>
                                            <th>Đơn hàng của bạn</th>
                                            <th>Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody class="order-details-body">
                                        {{-- Lặp qua các sản phẩm trong Giỏ hàng --}}
                                        @foreach ($cartItems as $item)
                                            @php
                                                // Tính toán giá dựa trên sale_price (giá khuyến mãi) hoặc price
                                                $price =
                                                    $item->product->sale_price > 0
                                                        ? $item->product->sale_price
                                                        : $item->product->price;
                                                $subtotal_item = $price * $item->quantity;
                                            @endphp
                                            <tr>
                                                <td>{{ $item->product->name }} (x{{ $item->quantity }})</td>
                                                <td>{{ number_format($subtotal_item, 0, ',', '.') }}₫</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tbody class="checkout-details">
                                        {{-- 1. Dòng Tổng phụ --}}
                                        <tr>
                                            <td><strong>Tổng phụ:</strong></td>
                                            <td>{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                                        </tr>

                                        {{-- 2. Dòng Giảm giá (Chỉ hiển thị nếu Session có mã giảm giá) --}}
                                        @if (session()->has('coupon'))
                                            <tr>
                                                <td><strong>Giảm giá:</strong></td>
                                                <td class="text-danger">
                                                    -{{ number_format(session('coupon')['discount'], 0, ',', '.') }}₫
                                                    <small>({{ session('coupon')['code'] }})</small>
                                                </td>
                                            </tr>
                                        @endif

                                        {{-- 3. Phí vận chuyển --}}
                                        <tr>
                                            <td><strong>Phí vận chuyển:</strong></td>
                                            <td>0₫ (Tạm thời miễn phí)</td>
                                        </tr>

                                        {{-- 4. Dòng Tổng cộng cuối cùng --}}
                                        <tr>
                                            <td><strong>Tổng cộng:</strong></td>
                                            <td>
                                                <strong style="color: #F28123; font-size: 1.2em;">
                                                    @php
                                                        $discount = session()->has('coupon')
                                                            ? session('coupon')['discount']
                                                            : 0;
                                                        $finalTotal = $subtotal - $discount;
                                                        if ($finalTotal < 0) {
                                                            $finalTotal = 0;
                                                        }
                                                    @endphp
                                                    {{ number_format($finalTotal, 0, ',', '.') }}₫
                                                </strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                {{-- Nút Đặt hàng --}}
                                <button type="submit" class="boxed-btn">Hoàn tất Đặt hàng</button>
                            </div>
                        </div>
                    </div> {{-- End row --}}
                </form> {{-- End Form Đặt hàng --}}
            </div>
        </div>

        {{-- Logo Carousel Section --}}
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
            /* Cải thiện tổng thể cho khu vực checkout */
            .checkout-section {
                padding-top: 50px;
                /* Giảm padding trên để gần banner hơn */
                padding-bottom: 50px;
            }

            /* ----------------------------------- */
            /* 1. CĂN GIỮA VÀ BỐ CỤC CHUNG */
            /* ----------------------------------- */

            /* Đảm bảo nội dung chính được căn giữa nếu có thể */
            .container {
                max-width: 1200px;
            }

            /* Cải thiện form và order summary */
            .checkout-accordion-wrap,
            .order-details-wrap {
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                /* Đổ bóng nhẹ để nổi bật */
                border-radius: 8px;
                overflow: hidden;
                background: #ffffff;
                padding: 20px;
            }

            /* ----------------------------------- */
            /* 2. HIỆU ỨNG VÀ MÀU SẮC NỔI BẬT */
            /* ----------------------------------- */

            /* Header của Accordion */
            .single-accordion .card-header {
                background-color: #f7f7f7;
                border-bottom: 1px solid #e0e0e0;
                padding: 15px 20px;
            }

            .single-accordion .card-header button {
                color: #ff8a00;
                /* Màu cam nổi bật cho tiêu đề */
                font-size: 18px;
                font-weight: bold;
                text-decoration: none;
                transition: color 0.3s;
            }

            .single-accordion .card-header button:hover {
                color: #e57300;
            }

            /* Input và Textarea */
            .billing-address-form input[type="text"],
            .billing-address-form input[type="email"],
            .billing-address-form input[type="tel"],
            .billing-address-form textarea {
                width: 100%;
                padding: 10px 15px;
                border: 1px solid #ced4da;
                border-radius: 4px;
                margin-bottom: 15px;
                transition: border-color 0.3s, box-shadow 0.3s;
            }

            .billing-address-form input:focus,
            .billing-address-form textarea:focus {
                border-color: #ff8a00;
                /* Hiệu ứng focus màu cam */
                box-shadow: 0 0 0 0.2rem rgba(255, 138, 0, 0.25);
            }

            /* ----------------------------------- */
            /* 3. CHI TIẾT ĐƠN HÀNG (ORDER SUMMARY) */
            /* ----------------------------------- */

            .order-details-wrap {
                background-color: #fcfcfc;
                /* Nền nhẹ cho phần tóm tắt */
                border: 2px solid #ff8a00;
                /* Viền cam nổi bật */
                padding: 25px;
            }

            .order-details th,
            .order-details td {
                padding: 10px 0;
                border: none;
            }

            .order-details thead th {
                font-size: 20px;
                color: #ff8a00;
                border-bottom: 2px solid #ff8a00;
            }

            .order-details-body tr:last-child {
                border-bottom: 1px solid #e0e0e0;
            }

            .checkout-details tr:last-child td {
                font-weight: bold;
                font-size: 1.1em;
                color: #333;
            }

            /* Tổng cộng nổi bật */
            .checkout-details tr:last-child td:last-child {
                color: #dc3545;
                /* Màu đỏ cho tổng cuối cùng */
                font-size: 1.2em;
            }

            /* Nút Hoàn tất Đặt hàng */
            .boxed-btn {
                display: block;
                width: 100%;
                text-align: center;
                padding: 12px 20px;
                background-color: #ff8a00;
                /* Màu nền cam */
                color: white !important;
                font-weight: bold;
                border: 2px solid #ff8a00;
                border-radius: 4px;
                margin-top: 20px;
                transition: background-color 0.3s, border-color 0.3s;
            }

            .boxed-btn:hover {
                background-color: #e57300;
                /* Hiệu ứng hover */
                border-color: #e57300;
            }

            /* Căn chỉnh lỗi validation */
            .text-danger {
                font-size: 0.9em;
                color: #dc3545 !important;
            }
        </style>
    @endsection
