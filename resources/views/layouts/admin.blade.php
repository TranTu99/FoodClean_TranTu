<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Fruitkha</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <style>
        body {
            background-color: #212529;
            color: white;
        }

        #sidebar-wrapper {
            width: 250px;
            height: 100vh;
            position: fixed;
            background: #1a1d20;
            border-right: 1px solid #444;
            padding-top: 20px;
        }

        #sidebar-wrapper a {
            padding: 15px 20px;
            display: block;
            color: #ccc;
            text-decoration: none;
            font-weight: bold;
        }

        #sidebar-wrapper a:hover,
        #sidebar-wrapper a.active {
            background: #f6a505;
            color: white !important;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
        }
    </style>
</head>

<body>

    <div id="sidebar-wrapper">
        <h4 class="text-center mb-4" style="color: #f6a505;">FRUITKHA ADMIN</h4>
        <a href="{{ route('admin.dashboard') }}" class="{{ Request::is('admin') ? 'active' : '' }}">🏠 Tổng quan</a>
        <a href="{{ route('admin.products.index') }}" class="{{ Request::is('admin/products*') ? 'active' : '' }}">📦
            Sản phẩm</a>
        <a href="{{ route('admin.orders.index') }}" class="{{ Request::is('admin/orders*') ? 'active' : '' }}">🛒 Đơn
            hàng</a>
        <hr style="border-color: #444;">
        <form action="{{ route('customer.logout') }}" method="POST">
            @csrf
            <button type="submit"
                style="background:none; border:none; color:#ff4d4d; padding-left:20px; font-weight:bold;">
                🚪 Đăng xuất
            </button>
        </form>
    </div>

    <div class="main-content">
        @yield('noidung_admin')
    </div>

    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</body>

</html>
