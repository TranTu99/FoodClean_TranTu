@extends('layouts.main')

@section('noidung')
    <style>
        .admin-container {
            display: flex;
            min-height: 100vh;
            margin-top: 130px;
            margin-bottom: 50px;
            background: #f8f9fa;
            border-radius: 20px;
            overflow: hidden;
        }

        .admin-main-content {
            flex: 1;
            padding: 40px;
            background: #fff;
        }

        .profile-card {
            background: #051922;
            color: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
        }

        .info-box {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            text-align: left;
            color: #333;
        }
    </style>

    <div class="container admin-container">
        <div class="admin-main-content">
            <div class="mb-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary"><i
                        class="fas fa-arrow-left"></i> Quay lại danh sách</a>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="profile-card">
                        <div
                            style="width: 80px; height: 80px; background: #f6a505; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold;">
                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                        </div>
                        <h4>{{ $customer->name }}</h4>
                        <p class="text-warning">Khách hàng thành viên</p>

                        <div class="info-box">
                            <p><strong>Email:</strong> {{ $customer->email }}</p>
                            <p><strong>Ngày gia nhập:</strong> {{ $customer->created_at->format('d/m/Y') }}</p>
                            <hr>
                            <p><strong>Tổng chi tiêu:</strong> <span
                                    class="text-success font-weight-bold">{{ number_format($totalSpent) }}₫</span></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <h4 class="mb-4" style="font-weight: 700;">Lịch sử đặt hàng ({{ $customer->orders->count() }})</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customer->orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                        <td>{{ number_format($order->total_amount) }}₫</td>
                                        <td>
                                            <span
                                                class="badge {{ $order->status == 'Paid' ? 'badge-success' : 'badge-warning' }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Chưa có đơn hàng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
