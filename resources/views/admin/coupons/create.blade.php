@extends('layouts.main')
@section('noidung')
    <div class="container mt-150 mb-150">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h2 class="mb-4 text-white">Tạo Mã Giảm Giá Mới</h2>
                <form action="{{ route('admin.coupons.store') }}" method="POST" class="bg-dark p-5 rounded">
                    @csrf
                    <div class="form-group">
                        <label class="text-white">Mã giảm giá (Ví dụ: KM2026)</label>
                        <input type="text" name="code" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="text-white">Loại giảm giá</label>
                        <select name="type" class="form-control">
                            <option value="fixed">Trừ tiền mặt (VNĐ)</option>
                            <option value="percent">Trừ theo phần trăm (%)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="text-white">Giá trị giảm</label>
                        <input type="number" name="value" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="text-white">Đơn hàng tối thiểu (VNĐ)</label>
                        <input type="number" name="min_order_value" class="form-control" value="0">
                    </div>

                    <div class="form-group">
                        <label class="text-white">Ngày hết hạn</label>
                        <input type="date" name="expiry_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning mt-3">Lưu mã giảm giá</button>
                </form>
            </div>
        </div>
    </div>
@endsection
