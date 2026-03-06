{{-- resources/views/menu.blade.php --}}

@if(isset($menu) && count($menu) > 0)

    <li class="nav-item submenu dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            DANH MỤC SẢN PHẨM
        </a>
        <ul class="dropdown-menu">
            @foreach($menu as $item)
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/shop/' . $item->slug) }}">
                        {{ $item->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link" href="#">Không có Danh Mục nào</a>
    </li>
@endif