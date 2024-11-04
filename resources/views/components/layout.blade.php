<li class="sidebar-item">
    <a href="#sidebarUser" data-bs-toggle="collapse">
        <i class="fa-regular fa-user"></i>
        <span>People</span>
        <span class="menu-arrow"></span>
    </a>
    <div class="collapse" id="sidebarUser">
        <ul class="nav-second-level">
            @foreach($menuItems as $item)
                <li class="sidebar-item">
                    <a href="{{ route($item['route']) }}">
                        <i class="fa-solid {{ $item['icon'] }}"></i>
                        <span>{{ $item['name'] }}</span>    
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</li>
