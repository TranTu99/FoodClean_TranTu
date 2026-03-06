@php
    $isAdmin = Auth::check() && Auth::user()->is_admin == 1;
@endphp
<div class="top-header-area" id="sticker">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 text-center">
                <div class="main-menu-wrap">
                    {{-- Logo --}}
                    <div class="site-logo">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo">
                        </a>
                    </div>
                    <nav class="main-menu">
                        <ul>
                            <li class="{{ isset($active_menu) && $active_menu == 'home' ? 'current-list-item' : '' }}">
                                <a href="{{ url('/') }}">Home</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ url('/') }}">Static Home</a></li>
                                    <li><a href="{{ url('/sliderhome') }}">Slider Home</a></li>
                                </ul>
                            </li>
                            <li class="{{ isset($active_menu) && $active_menu == 'about' ? 'current-list-item' : '' }}">
                                <a href="{{ route('about') }}">About</a>
                            </li>
                            <li
                                class="{{ isset($active_menu) && ($active_menu == 'er' || $active_menu == 'contact') ? 'current-list-item' : '' }}">
                                <a href="#">Pages</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('er') }}">404 page</a></li>
                                    <li><a href="{{ route('contact') }}">Contact</a></li>
                                </ul>
                            </li>
                            <li
                                class="{{ isset($active_menu) && ($active_menu == 'new' || $active_menu == 'singlenew') ? 'current-list-item' : '' }}">
                                <a href="{{ route('new') }}">News</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('new') }}">News</a></li>
                                    <li><a href="{{ url('/single-news') }}">Single News</a></li>
                                </ul>
                            </li>
                            <li
                                class="{{ isset($active_menu) && $active_menu == 'contact' ? 'current-list-item' : '' }}">
                                <a href="{{ route('contact') }}">Contact</a>
                            </li>
                            <li
                                class="{{ isset($active_menu) && ($menuItems ?? collect())->contains('slug', $active_menu) ? 'current-list-item' : '' }}">
                                <a href="#">Products</a>
                                <ul class="sub-menu">
                                    @forelse ($menuItems ?? [] as $category)
                                        <li
                                            class="{{ isset($active_menu) && $active_menu == $category->slug ? 'current-list-item' : '' }}">
                                            <a
                                                href="{{ route('category', $category->slug) }}">{{ $category->name }}</a>
                                        </li>
                                    @empty
                                        <li><a href="#">(Chưa có danh mục nào)</a></li>
                                    @endforelse
                                </ul>
                            </li>
                            <li
                                class="{{ isset($active_menu) && in_array($active_menu, ['shop', 'singleproduct', 'checkout', 'cart']) ? 'current-list-item' : '' }}">
                                <a href="{{ route('shop') }}">Shop</a>
                                <ul class="sub-menu">
                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                    <li><a href="{{ route('checkout') }}">Check Out</a></li>
                                    <li><a href="{{ route('cart') }}">Cart</a></li>
                                </ul>
                            </li>
                            <li class="header-icon-list-item">
                                <div class="header-icons">
                                    <div class="user-auth-menu-wrap">
                                        <a href="#" class="login-link">
                                            @auth
                                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                            @else
                                                <i class="fas fa-sign-in-alt"></i> Login
                                            @endauth
                                        </a>
                                        <ul class="sub-menu auth-sub-menu">
                                            @guest
                                                <li><a href="{{ route('customer.login') }}">Login</a></li>
                                                <li><a href="{{ route('customer.register') }}">Register</a></li>
                                            @endguest
                                            @auth
                                                @if ($isAdmin)
                                                    <li style="border-bottom: 1px solid #eee;">
                                                        <a href="{{ url('admin/products') }}"
                                                            style="color: #007bff; font-weight: bold;">
                                                            <i class="fas fa-tachometer-alt"></i> Quản Trị Hệ Thống
                                                        </a>
                                                    </li>
                                                @endif
                                                <li>
                                                    <a href="#"
                                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                        Đăng xuất
                                                    </a>
                                                </li>
                                            @endauth
                                        </ul>
                                    </div>
                                    <a class="shopping-cart" href="{{ route('cart') }}">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span id="cart-count">
                                            {{ \App\Http\Controllers\CartController::countCartItems() }}
                                        </span>
                                    </a>
                                    {{-- Tìm kiếm (Desktop) --}}
                                    <a class="mobile-hide search-bar-icon" href="#"><i
                                            class="fas fa-search"></i></a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    {{-- Tìm kiếm (Mobile) --}}
                    <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
                    <div class="mobile-menu"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- FORM ĐĂNG XUẤT (Cần thiết) --}}
@auth
    <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endauth
<div class="search-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="close-btn"><i class="fas fa-window-close"></i></span>
                <div class="search-bar">
                    <div class="search-bar-tablecell">
                        <h3>Tìm kiếm sản phẩm:</h3>
                        {{-- Route trỏ đúng đến 'search.product' --}}
                        <form action="{{ route('search.product') ?? url('/search') }}" method="GET">
                            <input type="text" name="query" placeholder="Nhập tên sản phẩm...">
                            <button type="submit">Tìm kiếm <i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchIcons = document.querySelectorAll('.search-bar-icon');
        const searchArea = document.querySelector('.search-area');
        const closeButton = document.querySelector('.search-area .close-btn');

        const toggleSearchArea = (e) => {
            e.preventDefault();
            searchArea.classList.toggle('active');
            // Tự động focus vào ô input khi mở search
            if (searchArea.classList.contains('active')) {
                const searchInput = searchArea.querySelector('input[name="query"]');
                if (searchInput) {
                    searchInput.focus();
                }
            }
        };
        searchIcons.forEach(icon => {
            icon.addEventListener('click', toggleSearchArea);
        });
        if (closeButton) {
            closeButton.addEventListener('click', (e) => {
                e.preventDefault();
                searchArea.classList.remove('active');
            });
        }
    });
</script>
<style>
    .main-menu nav ul li a {
        line-height: 50px;
        display: inline-block;
        padding: 15px 0;
    }

    .header-icons {
        line-height: normal;
        display: inline-flex;
        align-items: center;
        height: 50px;
        margin-left: 20px;
        vertical-align: middle;
    }

    .user-auth-menu-wrap {
        position: relative;
        display: inline-flex;
        align-items: center;
        vertical-align: middle;
        margin-right: 15px;
        height: 50px;
    }

    .user-auth-menu-wrap a.login-link {
        display: inline-flex;
        align-items: center;
        font-size: 14px;
        font-weight: 700;
        padding: 6px 14px;
        border: 2px solid #f28123;
        border-radius: 20px;
        line-height: 1.2;
        transition: all 0.3s;
        height: 38px;
        color: #f28123;
        text-decoration: none;
    }

    @auth .user-auth-menu-wrap a.login-link {
            border-color: #F28123;
            color: #F28123;
        }

        .user-auth-menu-wrap a.login-link:hover {
            background-color: #F28123;
            color: white;
        }
        @endauth
        @guest .user-auth-menu-wrap a.login-link:hover {
                background-color: #f28123;
                color: white;
            }
            @endguest
            .user-auth-menu-wrap .auth-sub-menu {
                background-color: white;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                padding: 10px 0;
                min-width: 200px;
                position: absolute;
                right: 0;
                left: auto;
                top: 100%;
                z-index: 99;
                opacity: 0;
                visibility: hidden;
                transform: scale(0.8);
                transition: all 0.3s ease;
                text-align: left;
            }

            .user-auth-menu-wrap:hover .auth-sub-menu {
                opacity: 1;
                visibility: visible;
                transform: scale(1);
            }

            .user-auth-menu-wrap .auth-sub-menu li a {
                display: block;
                padding: 8px 15px;
                line-height: 1.2;
                font-weight: 400;
                color: #000;
                transition: color 0.3s;
            }

            .user-auth-menu-wrap .auth-sub-menu li a:hover {
                color: #f28123;
                background-color: #f8f8f8;
            }

            .header-icons .shopping-cart,
            .header-icons .search-bar-icon {
                line-height: 50px;
                vertical-align: middle;
            }

            .search-area {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                z-index: 9999;
                display: none;
                opacity: 0;
                visibility: hidden;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .search-area.active {
                display: block;
                opacity: 1;
                visibility: visible;
            }

            .search-area .close-btn {
                position: absolute;
                right: 50px;
                top: 50px;
                font-size: 25px;
                color: #fff;
                cursor: pointer;
                transition: 0.3s;
            }

            .search-area .close-btn:hover {
                color: #f28123;
            }

            .search-area .search-bar {
                height: 100vh;
                display: table;
                width: 100%;
            }

            .search-area .search-bar-tablecell {
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }

            .search-area .search-bar-tablecell h3 {
                color: #fff;
                font-weight: 400;
                margin-bottom: 25px;
            }

            .search-area .search-bar-tablecell form {
                display: inline-block;
            }

            .search-area .search-bar-tablecell input {
                border: none;
                width: 400px;
                max-width: 90%;
                padding: 10px 15px;
                border-radius: 50px;
                outline: none;
                font-size: 16px;
                margin: 0 5px 0 0;
                display: inline-block;
            }

            .search-area .search-bar-tablecell button {
                background-color: #f28123;
                color: #fff;
                padding: 10px 30px;
                border: none;
                border-radius: 50px;
                font-size: 16px;
                cursor: pointer;
                transition: 0.3s;
                display: inline-block;
                margin-left: 5px;
                vertical-align: top;
            }

            .search-area .search-bar-tablecell button:hover {
                background-color: #ff9144;
            }

            @media (max-width: 767px) {
                .search-area .search-bar-tablecell form {
                    display: block;
                }

                .search-area .search-bar-tablecell input {
                    display: block;
                    width: 90%;
                    margin: 0 auto 15px auto;
                }

                .search-area .search-bar-tablecell button {
                    display: block;
                    width: 90%;
                    margin: 0 auto;
                }
            }
        </style>
