@extends('layouts.main')
@section('noidung')
    <style>
        body {
            background-color: #212529 !important;
            padding-top: 0 !important;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        #sidebar-wrapper {
            width: 250px;
            background-color: #212529;
            color: white;
            margin-top: 80px;
            z-index: 900;
            overflow-y: auto;
            border-right: 1px solid #444;
        }

        #sidebar-wrapper h3 {
            padding: 15px;
            margin-top: 0;
            border-bottom: 1px solid #444;
            font-size: 1.5rem;
            color: #fff;
        }

        #sidebar-wrapper a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 16px;
            color: #ccc;
            display: block;
            transition: background 0.3s;
        }

        #sidebar-wrapper a:hover {
            background-color: #f2b703;
            color: #fff;
        }

        #sidebar-wrapper a[style*="background-color: #007bff"] {
            background-color: #007bff !important;
            color: white !important;
        }

        .admin-main-content-area {
            flex-grow: 1;
            padding: 20px;
            padding-top: 100px;
            min-height: calc(100vh - 80px);
        }

        .admin-main-content-area h2 {
            color: #fff;
        }

        .admin-main-content-area .table {
            background-color: #fff;
            color: #cda853;
            border: 1px solid #ddd;
        }

        .admin-main-content-area .table thead {
            background-color: #322c31;
            color: #fff;
        }

        .admin-main-content-area .table th,
        .admin-main-content-area .table td {
            border-color: #ddd;
            color: #fa8109;
        }
    </style>
    <div class="admin-wrapper">

        <div id="sidebar-wrapper">
            <h3 style="padding: 15px; margin-top: 0; border-bottom: 1px solid #495057;">ADMIN PANEL</h3>
            <a href="{{ route('admin.products.index') }}"
                style="background-color: #f6a505; color: white !important; font-weight: bold;">
                📊 Xem Danh Sách Sản Phẩm
            </a>
            <a href="{{ route('admin.products.create') }}">
                ➕ Thêm Sản Phẩm Mới
            </a>
            <hr style="margin: 15px; border-color: #495057;">
            <a href="{{ route('customer.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-index').submit();">
                ↩️ Đăng Xuất
            </a>
            <form id="logout-form-index" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        {{-- NỘI DUNG CHÍNH --}}
        <div class="admin-main-content-area">
            <h2 class="mb-4">Quản Lý Sản Phẩm</h2>
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">Có lỗi xảy ra, vui lòng kiểm tra lại form.</div>
            @endif
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">➕ Thêm Sản Phẩm Mới</a>

            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white" style="border-radius: 5px; overflow: hidden;">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Giá</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                <td>{{ number_format($product->price) }} VNĐ</td>
                                <td>
                                    @if ($product->image)
                                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="btn btn-sm btn-warning">✏️
                                        Sửa</a>

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        {{-- Mã token này là một chuỗi ngẫu nhiên được lưu trữ trong Session của người dùng. vì sợ có form giả mạo khi bị tấn công mạng
                                        Khi form được gửi đi (POST, PUT, PATCH, DELETE), Laravel sẽ so sánh mã token gửi lên với mã token đang lưu trong Session. nếu đúng thì ok nếu không giống thì báo cáo lỗi 419 phiên hết hạn --}}
                                        @csrf{{-- <input type="hidden" name="_token" value="[mã token ngẫu nhiên]">  bảo vệ web khỏi tấn công CSRF --}}
                                        @method('DELETE') {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                        {{-- Vì form không hỗ trợ trực tiếp DELETE, Laravel sử dụng chỉ thị @method('DELETE') để giải quyết: --}}
                                        <button type="submit" class="btn btn-sm btn-danger">❌ Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Không tìm thấy sản phẩm nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
