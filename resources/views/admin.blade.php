@extends('layouts.main') {{-- Kế thừa layout chung để lấy Header và Footer --}}

@section('styles')
    {{-- CSS CỐ ĐỊNH SIDEBAR (Được viết trực tiếp để dễ quản lý) --}}
    <style>
        body {
            /* Giữ nguyên màu nền hoặc tùy chỉnh */
            background-color: #f8ff9a !important;
        }

        /* 1. ĐỊNH NGHĨA SIDEBAR */
        #sidebar-wrapper {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            /* Màu nền Sidebar */
            padding-top: 80px;
            /* Đẩy Sidebar xuống dưới Header/Navbar của layout.main */
            color: white;
            z-index: 1000;
        }

        #sidebar-wrapper a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            color: #f8f9fa;
            display: block;
            transition: background 0.3s;
        }

        #sidebar-wrapper a:hover {
            background-color: #495057;
            color: white;
        }

        /* 2. ĐỊNH NGHĨA KHU VỰC NỘI DUNG CHÍNH */
        .admin-content-wrapper {
            margin-left: 250px;
            /* Đẩy nội dung chính sang phải 250px */
            padding: 20px;
            min-height: 100vh;
        }
    </style>
@endsection

@section('content')
    {{-- KHU VỰC SIDEBAR --}}
    <div id="sidebar-wrapper">
        <h3 class="p-3 text-white">ADMIN PANEL</h3>
        <hr class="text-white mx-3">

        <a href="{{ route('admin.products.index') }}">
            <i class="fas fa-box"></i> Quản Lý Sản Phẩm
        </a>

        <a href="#">
            <i class="fas fa-tags"></i> Quản Lý Danh Mục
        </a>

        <a href="#">
            <i class="fas fa-users"></i> Quản Lý Người Dùng
        </a>

        <a href="{{ route('customer.logout') }}"
            onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
            <i class="fas fa-sign-out-alt"></i> Đăng Xuất
        </a>
        <form id="logout-form-admin" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    {{-- KHU VỰC NỘI DUNG CHÍNH (BODY ADMIN) --}}
    <div class="admin-content-wrapper">
        {{-- NỘI DUNG TỪ INDEX, CREATE, EDIT SẼ ĐƯỢC CHÈN VÀO ĐÂY --}}
        @yield('content')
    </div>
@endsection
