@extends('layouts.main')

@section('noidung')
    <div class="container mt-150 mb-150">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="text-white">Danh sách Mã Giảm Giá</h2>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-warning"> + Tạo mã mới</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Đơn tối thiểu</th>
                            <th>Hết hạn</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td><strong>{{ $coupon->code }}</strong></td>
                                <td>{{ $coupon->type == 'fixed' ? 'Tiền mặt' : 'Phần trăm' }}</td>
                                <td>{{ number_format($coupon->value) }}{{ $coupon->type == 'fixed' ? '₫' : '%' }}</td>
                                <td>{{ number_format($coupon->min_order_value) }}₫</td>
                                <td>{{ $coupon->expiry_date }}</td>
                                <td>
                                    @if ($coupon->expiry_date >= now()->toDateString())
                                        <span class="badge badge-success">Còn hạn</span>
                                    @else
                                        <span class="badge badge-danger">Hết hạn</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Bạn có thể thêm nút Xóa hoặc Sửa ở đây sau --}}
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
