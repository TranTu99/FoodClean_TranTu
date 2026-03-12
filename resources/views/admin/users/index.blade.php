@extends('layouts.main')

@section('noidung')
    <style>
        /* Dùng lại style cũ của Dashboard để đồng bộ */
        .admin-container {
            display: flex;
            min-height: 100vh;
            margin-top: 130px;
            margin-bottom: 50px;
            background: #f8f9fa;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .admin-sidebar {
            width: 280px;
            background: #051922;
            padding: 30px 0;
        }

        .admin-sidebar a {
            padding: 15px 25px;
            color: #bbbbbb;
            text-decoration: none;
            display: block;
        }

        .admin-sidebar a.active {
            color: #fff;
            background: linear-gradient(90deg, #f6a505, transparent);
            border-left: 5px solid #f6a505;
        }

        .admin-main-content {
            flex: 1;
            padding: 40px;
            background: #fff;
        }

        .user-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .user-table tr {
            background: #f9f9f9;
            transition: 0.3s;
        }

        .user-table tr:hover {
            transform: scale(1.01);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .user-table strong:hover {
            color: #f6a505 !important;
            /* Đổi sang màu cam khi di chuột vào tên */
            cursor: pointer;
        }

        .user-table td,
        .user-table th {
            padding: 15px;
            vertical-align: middle;
            border: none;
        }

        .avatar-circle {
            width: 40px;
            height: 40px;
            background: #f6a505;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>

    <div class="container admin-container">
        <div class="admin-sidebar">
            <h5 class="text-center text-warning mb-4">ADMIN PANEL</h5>
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Tổng quan</a>
            <a href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}"><i class="fas fa-shopping-cart"></i> Đơn hàng</a>
            <a href="{{ route('admin.users.index') }}" class="active"><i class="fas fa-users"></i> Khách hàng</a>
        </div>

        <div class="admin-main-content">
            <div class="d-flex justify-content-between mb-4">
                <h2 style="font-weight: 700;">Danh Sách Khách Hàng</h2>
                <span class="badge badge-dark p-3">{{ $customers->total() }} thành viên</span>
            </div>

            <table class="user-table">
                <thead>
                    <tr style="background: transparent;">
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Ngày đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle mr-2">{{ strtoupper(substr($user->name, 0, 1)) }}</div>

                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        style="color: #051922; text-decoration: none;">
                                        <strong>{{ $user->name }}</strong>
                                    </a>
                                </div>
                            </td>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-user-slash"></i>
                                    Khóa</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
@endsection
