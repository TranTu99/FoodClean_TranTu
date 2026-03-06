@extends('layouts.main')
@section('noidung')
    @php
        $title = 'Đăng ký';
        $subtitle = 'Tạo tài khoản mới';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))
    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Đăng Ký Tài Khoản</h2>
                        <p>Vui lòng điền thông tin bên dưới để tạo tài khoản mua sắm.</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Vui lòng kiểm tra lại thông tin đăng ký.
                        </div>
                    @endif
                    <div class="contact-form">
                        <form method="POST" action="{{ route('customer.register') }}" id="fruitkha-register-form">
                            @csrf
                            {{-- Thu thập dữ liệu, Giữ lại dữ liệu lỗi, và Hiển thị thông báo lỗi. --}}
                            <p>
                                <input type="text" placeholder="Họ và Tên" name="name" value="{{ old('name') }}"
                                    required autofocus class="text-input">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </p>
                            <p>
                                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}"
                                    required class="text-input">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </p>
                            <p>
                                <input type="password" placeholder="Mật khẩu (Tối thiểu 8 ký tự)" name="password" required
                                    class="text-input">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </p>
                            <p>
                                <input type="password" placeholder="Xác nhận Mật khẩu" name="password_confirmation" required
                                    class="text-input">
                            </p>
                            <p>
                                <input type="submit" value="Đăng Ký">
                            </p>
                        </form>
                    </div>
                    <div class="mt-3 text-center">
                        <p>Đã có tài khoản? <a href="{{ route('customer.login') }}">Đăng nhập ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Thêm CSS để đảm bảo input đều và đẹp --}}
    <style>
        /* CSS tùy chỉnh để các input trong form đăng ký/đăng nhập giống với theme hơn */
        #fruitkha-register-form .text-input,
        #fruitkha-login-form .text-input {
            width: 100%;
            /* Chiếm toàn bộ chiều rộng thẻ <p> */
            height: 60px;
            /* Chiều cao đồng nhất */
            padding: 0 15px;
            /* Giữ khoảng đệm */
            border: 1px solid #051922;
            /* Viền màu sẫm */
            color: #051922;
            font-size: 15px;
            border-radius: 0;
            /* Loại bỏ bo góc nếu có */
            -webkit-box-shadow: none;
            box-shadow: none;
            -webkit-transition: all 0.3s ease 0s;
            -moz-transition: all 0.3s ease 0s;
            -ms-transition: all 0.3s ease 0s;
            -o-transition: all 0.3s ease 0s;
            transition: all 0.3s ease 0s;
        }

        #fruitkha-register-form .text-input:focus,
        #fruitkha-login-form .text-input:focus {
            border-color: #f28123;
            /* Màu cam khi focus */
        }

        .contact-form small.text-danger {
            display: block;
            /* Hiển thị lỗi dưới input */
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 0.9em;
            color: #dc3545 !important;
        }
    </style>
@endsection
