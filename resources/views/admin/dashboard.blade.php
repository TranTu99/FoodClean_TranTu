@extends('layouts.main')

@section('noidung')
    <style>
        /* Tổng thể khu vực Admin */
        .admin-container {
            display: flex;
            min-height: 100vh;
            margin-top: 130px;
            margin-bottom: 50px;
            background: #f8f9fa;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        /* Sidebar thiết kế mới */
        .admin-sidebar {
            width: 280px;
            background: #051922;
            /* Màu tối của Fruitkha */
            padding: 30px 0;
            display: flex;
            flex-direction: column;
        }

        .admin-sidebar h5 {
            color: #f6a505;
            letter-spacing: 2px;
            font-weight: 700;
            padding: 0 25px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-sidebar a {
            padding: 15px 25px;
            color: #bbbbbb;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: 0.3s;
            font-size: 15px;
        }

        .admin-sidebar a i {
            margin-right: 15px;
            width: 20px;
        }

        .admin-sidebar a:hover,
        .admin-sidebar a.active {
            color: #fff;
            background: linear-gradient(90deg, #f6a505, transparent);
            border-left: 5px solid #f6a505;
        }

        /* Nội dung chính */
        .admin-main-content {
            flex: 1;
            padding: 40px;
            background: #fdfdfd;
        }

        /* Card thống kê kiểu Gradient */
        .stat-card {
            border: none;
            padding: 25px;
            border-radius: 15px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-card:hover {
            transform: translateY(-10px);
        }

        .bg-gradient-revenue {
            background: linear-gradient(135deg, #f6a505 0%, #ffc107 100%);
        }

        .bg-gradient-orders {
            background: linear-gradient(135deg, #2a1891 0%, #0f9de4 100%);
        }

        .bg-gradient-users {
            background: linear-gradient(135deg, #28a745 0%, #5dd37b 100%);
        }

        .bg-gradient-products {
            background: linear-gradient(135deg, #dc3545 0%, #ff5e6d 100%);
        }

        .stat-card h3 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 0.9rem;
            opacity: 0.9;
            text-transform: uppercase;
            margin: 0;
        }

        /* Bảng hoạt động gần đây */
        .activity-table {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .badge-paid {
            background: #d4edda;
            color: #155724;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
    </style>

    <div class="container admin-container">
        <div class="admin-sidebar">
            <h5 class="text-center">ADMIN PANEL</h5>
            <a href="{{ route('admin.dashboard') }}" class="active"><i class="fas fa-chart-line"></i> Tổng quan</a>
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
            <a href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i> Khách hàng</a>
            <a href="#"><i class="fas fa-cog"></i> Cài đặt</a>
        </div>

        <div class="admin-main-content">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h2 style="font-weight: 700; color: #051922;">Chào quay trở lại, Admin!</h2>
                    <p class="text-muted">Đây là tình hình kinh doanh của Fruitkha hôm nay.</p>
                </div>
                <button class="btn btn-warning"
                    style="background: #f6a505; color: white; border-radius: 30px; padding: 10px 25px; font-weight: bold;">
                    <a href="{{ route('admin.orders.export') }}" class="">
                        <i class="fas fa-file-excel"></i> Xuất Báo Cáo (CSV)
                    </a>
                </button>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card bg-gradient-revenue">
                        <h3>{{ number_format($totalRevenue) }}₫</h3>
                        <p>Tổng doanh thu</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card bg-gradient-orders">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Đơn hàng mới</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card bg-gradient-users">
                        <h3>{{ $totalCustomers }}</h3>
                        <p>Khách hàng</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stat-card bg-gradient-products">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Sản phẩm</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="activity-table">
                        <h5 class="mb-4" style="font-weight: 700;">Đơn hàng cần xử lý</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Khách Hàng</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Bạn có thể lấy 5 đơn hàng mới nhất từ Controller và loop ở đây --}}
                                <tr>
                                    <td>#ORD-8822</td>
                                    <td>Trần Tứ</td>
                                    <td>550,000₫</td>
                                    <td><span class="badge-paid">Đã thanh toán</span></td>
                                </tr>
                                <tr>
                                    <td>#ORD-8821</td>
                                    <td>Nguyễn Văn A</td>
                                    <td>120,000₫</td>
                                    <td><span class="badge-paid">Đã thanh toán</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="activity-table" style="background: #051922; color: white;">
                        <h5 class="mb-4" style="color: #f6a505;">Thao tác nhanh</h5>
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <a href="{{ route('admin.products.create') }}" class="text-white text-decoration-none">
                                    <i class="fas fa-plus-circle text-warning mr-2"></i> Thêm sản phẩm mới
                                </a>
                            </li>
                            <li class="mb-3">
                                <a href="{{ route('admin.coupons.create') }}">
                                    🎟️ Tạo Mã Giảm Giá
                                </a>
                            </li>
                            <li>
                                <a href="#" class="text-white text-decoration-none">
                                    <i class="fas fa-envelope text-warning mr-2"></i> Kiểm tra tin nhắn
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
