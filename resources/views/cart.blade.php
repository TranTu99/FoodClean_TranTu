@extends('layouts.main')

@section('noidung')
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <h3>Search For:</h3>
                            <input type="text" placeholder="Keywords">
                            <button type="submit">Search <i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $title = 'Giỏ hàng';
        $subtitle = 'Quản lý sản phẩm';
    @endphp
    @include('partials.hero_banner', compact('title', 'subtitle'))
    <div class="cart-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif
                    @if (session('info'))
                        <div class="alert alert-info text-center">{{ session('info') }}</div>
                    @endif
                    <div class="cart-table-wrap">
                        <form action="{{ route('cart.update') }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <table class="cart-table">
                                <thead class="cart-table-head">
                                    <tr class="table-head-row">
                                        <th class="product-remove">Xóa</th>
                                        <th class="product-image">Ảnh</th>
                                        <th class="product-name">Tên sản phẩm</th>
                                        <th class="product-price">Giá (VNĐ)</th>
                                        <th class="product-quantity">Số lượng</th>
                                        <th class="product-total">Tổng (VNĐ)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- isnotEmpty là chưa ít nhất 1 phần tử true và ngược lại --}}
                                    @if (isset($cartItems) && $cartItems->isNotEmpty())
                                        @foreach ($cartItems as $item)
                                            <tr class="table-body-row">
                                                {{-- CỘT XÓA SẢN PHẨM: Dùng BUTTON và Simple JS Submit Form --}}
                                                {{-- KHÔNG CÓ FORM NÀO TRONG TD NÀY NỮA --}}
                                                <td class="product-remove">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                                                            document.getElementById('remove-form-{{ $item->product_id }}').submit();
                                                        }">
                                                        <i class="far fa-window-close"></i> XÓA
                                                    </button>
                                                </td>
                                                {{-- Ảnh, Tên, Giá (Lấy từ $item->product) --}}
                                                <td class="product-image">
                                                    <img src="{{ asset($item->product->image) }}"
                                                        alt="{{ $item->product->name }}">
                                                </td>
                                                <td class="product-name">{{ $item->product->name }}
                                                </td>
                                                @php
                                                    $price =
                                                        $item->product->sale_price > 0
                                                            ? $item->product->sale_price
                                                            : $item->product->price;
                                                @endphp
                                                <td class="product-price">
                                                    {{-- Tham số 2 (0)	Số lượng chữ số thập phân (đặt là 0 vì Việt Nam Đồng không dùng số lẻ).
                                                    Tham số 3 (',')	Dấu phân cách thập phân (Không dùng, nhưng phải truyền vào).
                                                    Tham số 4 ('.')	Dấu phân cách hàng nghìn (sử dụng dấu chấm). --}}
                                                    {{ number_format($price, 0, ',', '.') }}₫
                                                </td>

                                                {{-- Input số lượng (Là một phần của Form PATCH lớn bên ngoài) --}}
                                                <td class="product-quantity">
                                                    <input type="number" name="quantities[{{ $item->product_id }}]"
                                                        value="{{ $item->quantity }}" min="1" class="quantity-input"
                                                        data-id="{{ $item->product_id }}" {{-- THÊM DÒNG NÀY --}}
                                                        data-price="{{ $price }}"
                                                        style="width: 70px; text-align: center;">
                                                </td>
                                                {{-- Cột Tổng phụ thu cho từng sản phẩm --}}
                                                <td class="product-total item-subtotal-display">
                                                    {{ number_format($item->quantity * $price, 0, ',', '.') }}₫
                                                </td>
                                            </tr>
                                        @endforeach
                                        {{-- Nút Cập nhật Giỏ hàng (Nằm trong form PATCH) --}}
                                        <tr class="table-body-row">
                                            <td colspan="6" class="text-right">
                                                <button type="submit" class="boxed-btn btn-sm"
                                                    style="margin-top: 20px;">Cập nhật Giỏ hàng</button>
                                            </td>
                                        </tr>
                                    @else
                                        <tr class="table-body-row">
                                            <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống!</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </form>
                    </div>
                    {{-- Form Xóa ẨN: Các Form này nằm ngoài Form PATCH lớn để tránh lỗi lồng nhau --}}
                    @if (isset($cartItems) && $cartItems->isNotEmpty())
                        @foreach ($cartItems as $item)
                            <form id="remove-form-{{ $item->product_id }}"
                                action="{{ route('cart.remove', $item->product_id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    @endif
                    {{-- HẾT Form Xóa ẨN --}}
                </div>
                {{-- Cột tổng tiền --}}
                @if (isset($cartItems) && $cartItems->isNotEmpty())
                    <div class="col-lg-4 offset-lg-8">
                        <div class="total-section">
                            <table class="total-table">
                                <thead class="total-table-head">
                                    <tr class="table-total-row">
                                        <th>Tổng Giỏ hàng</th>
                                        <th>Giá trị</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="total-data">
                                        <td><strong>Tổng phụ: </strong></td>
                                        <td class="subtotal-display">{{ number_format($subtotal, 0, ',', '.') }}₫</td>
                                    </tr>

                                    {{-- HIỂN THỊ MÃ GIẢM GIÁ NẾU CÓ --}}
                                    @if (session()->has('coupon'))
                                        <tr class="total-data">
                                            <td>
                                                <strong>Giảm giá ({{ session('coupon')['code'] }}):</strong>
                                                <br>
                                                <a href="{{ route('coupon.remove') }}" class="text-danger small"><i
                                                        class="fas fa-trash"></i> Xóa mã</a>
                                            </td>
                                            <td class="text-danger">
                                                -{{ number_format(session('coupon')['discount'], 0, ',', '.') }}₫</td>
                                        </tr>
                                    @endif

                                    <tr class="total-data">
                                        <td><strong>Tổng cộng:</strong> </td>
                                        <td>
                                            <strong class="grand-total-display">
                                                {{-- Tính toán tổng cuối cùng = Tổng phụ - giảm giá (nếu có) --}}
                                                @php
                                                    $discount = session()->has('coupon')
                                                        ? session('coupon')['discount']
                                                        : 0;
                                                    $grandTotal = $subtotal - $discount;
                                                @endphp
                                                {{ number_format($grandTotal, 0, ',', '.') }}₫
                                            </strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="cart-buttons">
                                <a href="{{ route('checkout') }}" class="boxed-btn black">Tiến hành Thanh toán</a>
                            </div>
                        </div>

                        <div class="coupon-section mt-5">
                            <h3>Áp dụng Mã giảm giá</h3>
                            <div class="coupon-form-wrap">
                                {{-- SỬA FORM NÀY ĐỂ GỬI LÊN CONTROLLER --}}
                                <form action="{{ route('coupon.apply') }}" method="POST">
                                    @csrf
                                    <p><input type="text" name="coupon_code" placeholder="Nhập mã giảm giá..." required>
                                    </p>
                                    <p><input type="submit" value="Áp dụng"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="logo-carousel-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/1.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/2.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/3.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/4.png') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/img/company-logos/5.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Script JavaScript (Chỉ giữ lại phần tính toán tổng tiền động) --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- tính toán lại và cập nhật tổng tiền Giỏ hàng (Subtotal và Grand Total) ngay lập tức trên giao diện --}}
    {{-- đảm bảo rằng người dùng thấy tổng tiền thay đổi theo thời gian thực mà không cần tải lại trang. --}}
    <script>
        $(document).ready(function() {

            // 1. Hàm định dạng tiền tệ Việt Nam
            function formatVND(n) {
                return n.toLocaleString('vi-VN') + '₫';
            }

            // 2. Hàm cập nhật hiển thị tổng tiền trên giao diện
            function updateCartTotals() {
                var grandTotal = 0;
                // Lấy mức giảm giá hiện tại từ Session (do Laravel truyền sang)
                var couponDiscount = {{ session()->has('coupon') ? session('coupon')['discount'] : 0 }};

                $('.quantity-input').each(function() {
                    var input = $(this);
                    var price = parseFloat(input.data('price'));
                    var quantity = parseInt(input.val());

                    // Kiểm tra nếu số lượng không hợp lệ
                    if (isNaN(quantity) || quantity < 1) {
                        quantity = 1;
                        input.val(1);
                    }

                    // Tính tiền cho từng dòng sản phẩm
                    var itemSubtotal = price * quantity;
                    input.closest('tr').find('.item-subtotal-display').text(formatVND(itemSubtotal));

                    grandTotal += itemSubtotal;
                });

                // Hiển thị Tổng phụ (chưa giảm giá)
                $('.subtotal-display').text(formatVND(grandTotal));

                // Tính Tổng cộng cuối cùng (sau khi trừ Coupon)
                var finalTotal = grandTotal - couponDiscount;
                if (finalTotal < 0) finalTotal = 0;

                $('.grand-total-display').text(formatVND(finalTotal));
            }

            // 3. Lắng nghe sự kiện thay đổi số lượng (Sử dụng 'change' để tránh gửi request liên tục khi đang gõ)
            $(document).on('change', '.quantity-input', function() {
                var input = $(this);
                var productId = input.data('id'); // Lấy ID sản phẩm từ thuộc tính data-id
                var quantity = input.val();

                // Hiệu ứng chờ cho người dùng (tùy chọn)
                input.css('opacity', '0.5');

                // Gửi Ajax để cập nhật số lượng vào Database
                $.ajax({
                    url: "{{ route('cart.update') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "PATCH", // NHƯNG thêm dòng này để Laravel hiểu là PATCH
                        product_id: productId,
                        quantity: quantity
                    },
                    success: function(response) {
                        input.css('opacity', '1');
                        console.log("Database đã cập nhật số lượng mới.");

                        // Sau khi lưu DB thành công, cập nhật lại các con số trên giao diện
                        updateCartTotals();

                        /** * LƯU Ý: Nếu logic Coupon của bạn phức tạp (ví dụ: giảm 10% tổng đơn)
                         * thì nên dùng location.reload() để Server tính lại Coupon chính xác nhất.
                         * Nếu là giảm số tiền cố định thì updateCartTotals() là đủ.
                         **/
                    },
                    error: function() {
                        input.css('opacity', '1');
                        alert('Không thể cập nhật số lượng. Vui lòng kiểm tra kết nối!');
                    }
                });
            });

            // 4. Khởi chạy hàm tính toán ngay khi load trang
            updateCartTotals();
        });
    </script>
@endsection
