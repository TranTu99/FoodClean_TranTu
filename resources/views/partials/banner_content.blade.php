<div class="container">
    <div class="row">
        {{-- Lưu ý: offset-lg-2 + col-lg-9 = 11. Đổi thành col-lg-10 offset-lg-1 cho cân bằng nếu cần --}}
        <div class="col-lg-9 offset-lg-2 text-center">
            <div class="hero-text">
                <div class="hero-text-tablecell">
                    {{-- THÊM CLASS TẠI ĐÂY --}}
                    <p class="subtitle-text">{{ isset($subtitle) ? $subtitle : 'Fresh & Organic' }}</p>

                    <h1>{{ isset($title) ? $title : 'Delicious Seasonal Fruits' }}</h1>
                    <div class="hero-btns">
                        <a href="shop.html" class="boxed-btn">Fruit Collection</a>
                        <a href="contact.html" class="bordered-btn">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
