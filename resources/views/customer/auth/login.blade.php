@extends('layouts.main')

@section('noidung')
    @php
        $title = 'Đăng nhập';
        $subtitle = 'Truy cập tài khoản của bạn';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))
    <div class="contact-from-section mt-150 mb-150">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="form-title">
                        <h2>Đăng Nhập</h2>
                        <p>Chào mừng trở lại! Vui lòng nhập thông tin để tiếp tục.</p>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Thông tin đăng nhập không hợp lệ. Vui lòng kiểm tra lại Email và Mật khẩu.
                        </div>
                    @endif
                    <div class="contact-form">
                        <form method="POST" action="{{ route('customer.login') }}" id="fruitkha-login-form">
                            @csrf
                            <p>
                                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}"
                                    required autofocus class="text-input">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </p>
                            <p>
                                <input type="password" placeholder="Mật khẩu" name="password" required class="text-input">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </p>
                            <p class="d-flex justify-content-between">
                                <label>
                                    <input type="checkbox" name="remember"> Ghi nhớ tôi
                                </label>
                                <a href="#">Quên mật khẩu?</a>
                            </p>
                            <p><input type="submit" value="Đăng Nhập"></p>
                        </form>
                    </div>
                    <div class="mt-3 text-center">
                        <p>Chưa có tài khoản? <a href="{{ route('customer.register') }}">Đăng ký ngay</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #fruitkha-register-form .text-input,
        #fruitkha-login-form .text-input {
            width: 100%;
            height: 60px;
            padding: 0 15px;
            border: 1px solid #051922;
            color: #051922;
            font-size: 15px;
            border-radius: 0;
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
        }

        .contact-form small.text-danger {
            display: block;
            margin-top: 5px;
            margin-bottom: 5px;
            font-size: 0.9em;
            color: #dc3545 !important;
        }
    </style>
@endsection
