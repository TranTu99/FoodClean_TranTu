{{-- 🎨 CSS được nhúng trực tiếp để thêm ảnh nền và FIX CĂN GIỮA TUYỆT ĐỐI BẰNG FLEXBOX --}}
<style>
    /* 1. Định nghĩa ảnh nền cho tất cả các trang phụ */
    .breadcrumb-bg {
        background-image: url('{{ asset('assets/img/abt.jpg') }}') !important;
        background-size: cover !important;
        background-position: center !important;
        background-repeat: no-repeat !important;
        height: 300px !important;
        /* Chiều cao cố định */
        position: relative !important;
        z-index: 1 !important;

        /* 🔥 CƠ CHẾ FLEXBOX ĐỂ CĂN GIỮA HOÀN HẢO */
        display: flex !important;
        align-items: center !important;
        /* Căn giữa theo chiều dọc (trên/dưới) */
        justify-content: center !important;
        /* Căn giữa theo chiều ngang (trái/phải) */
        /* Flexbox hoạt động tốt hơn Table-cell trong nhiều trường hợp */
    }

    /* Tạo lớp phủ (Overlay) cho ảnh nền */
    .breadcrumb-bg::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: -1;
    }

    /* 2. Định dạng chữ trong banner */
    .breadcrumb-text p {
        /* Subtitle */
        color: #FFD700 !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        margin-bottom: 5px !important;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8) !important;
    }

    .breadcrumb-text h1 {
        /* Title chính */
        color: white !important;
        font-size: 42px !important;
        font-weight: 900 !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8) !important;
    }

    /* Vô hiệu hóa/Reset các thuộc tính căn chỉnh cũ */
    .breadcrumb-text {
        /* Không cần display: table-cell nữa */
        display: block !important;
        height: auto !important;
        /* Để nội dung tự co giãn */
        padding-top: 0 !important;
        padding-bottom: 0 !important;
    }
</style>

<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        {{-- THÊM MỘT DIV BAO BỌC NỘI DUNG TEXT NẾU CẦN ĐỂ FLEXBOX NHẬN DIỆN TỐT HƠN --}}
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>{{ isset($subtitle) ? $subtitle : '' }}</p>
                    <h1>{{ isset($title) ? $title : '' }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
