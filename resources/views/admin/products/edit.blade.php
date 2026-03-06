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
            background-color: #343a40;
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

        .admin-main-content-area h2,
        .admin-main-content-area .form-label {
            color: #fff;
        }
    </style>
    <div class="admin-wrapper">
        <div id="sidebar-wrapper">
            <h3 style="padding: 15px; margin-top: 0; border-bottom: 1px solid #495057;">ADMIN PANEL</h3>
            <a href="{{ route('admin.products.index') }}">
                📊 Xem Danh Sách Sản Phẩm
            </a>
            <a href="{{ route('admin.products.create') }}">
                ➕ Thêm Sản Phẩm Mới
            </a>
            <hr style="margin: 15px; border-color: #495057;">
            <a href="{{ route('customer.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-edit').submit();">
                ↩️ Đăng Xuất
            </a>
            <form id="logout-form-edit" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        {{-- NỘI DUNG --}}
        <div class="admin-main-content-area">
            <h2>Chỉnh Sửa Sản Phẩm: {{ $product->name }}</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data"
                class="bg-dark p-4 rounded shadow-sm" style="color: white;">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="name" class="form-label">Tên Sản Phẩm</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Danh Mục</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">-- Chọn Danh Mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Giá (VNĐ)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                        value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô Tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Ảnh Sản Phẩm (Để trống nếu không muốn thay đổi)</label>
                    <input type="file" class="form-control" id="image" name="image">
                    @if ($product->image)
                        <small class="text-muted d-block mt-2">Ảnh hiện tại:</small>
                        <img src="{{ asset($product->image) }}" alt="Ảnh hiện tại"
                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 4px;">
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Cập Nhật Sản Phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
@endsection
