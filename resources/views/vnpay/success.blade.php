@extends('layouts.main')

@section('noidung')
    {{-- Phần Header Banner giống trang giỏ hàng --}}
    @php
        $title = 'Thanh toán thành công';
        $subtitle = 'Cảm ơn bạn đã mua hàng';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))

    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    {{-- Biểu tượng và thông báo --}}
                    <div class="success-content" style="padding: 50px 0;">
                        <div class="icon-wrap mb-4">
                            <i class="fas fa-check-circle" style="font-size: 80px; color: #F28123;"></i>
                        </div>
                        <h2 style="font-size: 36px; margin-bottom: 20px;">XÁC NHẬN THANH TOÁN THÀNH CÔNG!</h2>

                        <div class="order-info mb-4" style="font-size: 18px; line-height: 1.8;">
                            <p>Mã đơn hàng của bạn là: <strong style="color: #F28123;">#{{ $orderId }}</strong></p>
                            <p>Chúng tôi đã nhận được thanh toán và đang chuẩn bị những thực phẩm tươi sạch nhất cho bạn.
                            </p>
                            <p class="text-muted"><i>Giỏ hàng của bạn hiện đã được làm trống.</i></p>
                        </div>

                        <div class="cart-buttons">
                            {{-- Nút quay về trang chủ sử dụng style boxed-btn của bạn --}}
                            <a href="{{ url('/') }}" class="boxed-btn">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logo Carousel (Giữ lại cho đồng bộ với các trang khác) --}}
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
@endsection
