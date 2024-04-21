<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="dashboard" class="brand-link">
        <img src="/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @php
                $user = Auth::user();

                if ($user && $user->shop_id) {
                    $shopkeeper = \App\Models\Shopkeeper::join('users', 'shopkeepers.id', '=', 'users.shop_id')
                        ->where('users.id', $user->id)
                        ->select('shopkeepers.image')
                        ->first();

                    if ($shopkeeper) {
                        $image = 'images/shopkeeper_images/' . $shopkeeper->image;
                    } else {
                        // If the shopkeeper is not found, assign a default image path
                        $image = '/dist/img/user2-160x160.jpg';
                    }
                } else {
                    // If the user or shop_id is not available, assign a default image path
                    $image = '/dist/img/user2-160x160.jpg';
                }
                @endphp

                <img src="{{ asset($image) }}" alt="Shop Logo" class="brand-image img-circle" style="opacity: .8">
            </div>


            <div class="info">
                @auth
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                @endauth
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu Items -->
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link {{ request()->routeIs('index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-home"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Auth::user()->role == 1)
            <li class="nav-item">
                <a href="/shopkeepers" class="nav-link {{ request()->routeIs('Shopkeeper') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-store"></i>
                    <p>Shopkeeper</p>
                </a>
            </li>
            @endif
            <li class="nav-item">
                <a href='/products' class="nav-link {{ request()->routeIs('product') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Products</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/categories" class="nav-link {{ request()->routeIs('Category') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/customer" class="nav-link {{ request()->routeIs('Customer') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Clients</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="/order" class="nav-link {{ request()->routeIs('Order') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>Order-report</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                    <i class="nav-icon fa fa-user-circle"></i>
                    <p>Log Out</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

            <!-- Add more sidebar menu items as needed -->
        </ul>
        <!-- End Sidebar Menu Items -->
    </div>
    <!-- End Sidebar -->
</aside>
