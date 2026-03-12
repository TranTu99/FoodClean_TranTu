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
            border-bottom: 1px solid #495057;
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

        /* Highlight cho mục Đơn hàng đang chọn */
        .active-admin-link {
            background-color: #f6a505 !important;
            color: white !important;
            font-weight: bold;
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
            border: 1px solid #ddd;
        }

        .admin-main-content-area .table thead {
            background-color: #322c31;
            color: #fff;
        }

        .admin-main-content-area .table td {
            color: #fa8109;
            vertical-align: middle;
        }

        /* Màu sắc cho các Badge trạng thái */
        .badge-paid {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #000;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
    </style>

    <div class="admin-wrapper">
        <div id="sidebar-wrapper">
            <h3>ADMIN PANEL</h3>
            <a href="{{ route('admin.products.index') }}">
                📦 Quản lý Sản Phẩm
            </a>
            {{-- Mục Đơn hàng sẽ được highlight --}}
            <a href="{{ route('admin.orders.index') }}" class="active-admin-link">
                🛒 Quản Lý Đơn Hàng
            </a>
            <a href="{{ route('admin.products.create') }}">
                ➕ Thêm Sản Phẩm Mới
            </a>
            <hr style="margin: 15px; border-color: #495057;">
            <a href="{{ route('customer.logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form-orders').submit();">
                ↩️ Đăng Xuất
            </a>
            <form id="logout-form-orders" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>

        <div class="admin-main-content-area">
            <h2 class="mb-4">Danh Sách Đơn Hàng</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Khách Hàng</th>
                            <th>SĐT / Địa Chỉ</th>
                            <th>Tổng Tiền</th>
                            <th>Thanh Toán</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Đặt</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td style="font-weight: bold;">#{{ $order->id }}</td>
                                <td>
                                    {{ $order->user->name ?? 'N/A' }}<br>
                                    <small class="text-muted">{{ $order->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    {{ $order->phone_number }}<br>
                                    <small>{{ $order->shipping_address }}</small>
                                </td>
                                <td style="font-weight: bold;">{{ number_format($order->total_amount) }}₫</td>
                                <td>
                                    @if ($order->status == 'Paid')
                                        <span class="badge-paid">✅ Đã Thanh Toán</span>
                                    @else
                                        <span class="badge-pending">⏳ Chờ Thanh Toán</span>
                                    @endif
                                    <br><small class="text-muted">{{ strtoupper($order->payment_method) }}</small>
                                </td>
                                <td>
                                    {{-- Form cập nhật trạng thái nhanh --}}
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-control-sm" onchange="this.form.submit()"
                                            style="border: 1px solid #fa8109; color: #fa8109; font-weight: bold;">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ
                                                xử lý</option>
                                            <option value="processing"
                                                {{ $order->status == 'processing' ? 'selected' : '' }}>Đang giao</option>
                                            <option value="completed"
                                                {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                            <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>
                                                Đã hủy</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="color: #666 !important;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Chưa có đơn hàng nào được đặt.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
