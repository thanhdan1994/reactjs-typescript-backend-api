<!DOCTYPE html>
<html lang="en">
@yield('head')
<body>
<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="/"><img src="{{asset('admin/assets/images/logo.svg')}}" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="/"><img src="{{asset('admin/assets/images/logo-mini.svg')}}" alt="logo" /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">
                <form class="d-flex align-items-center h-100" action="#">
                    <div class="input-group">
                        <div class="input-group-prepend bg-transparent">
                            <i class="input-group-text border-0 mdi mdi-magnify"></i>
                        </div>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
                    </div>
                </form>
            </div>
            <ul class="navbar-nav navbar-nav-right">
                <li class="nav-item nav-profile dropdown">
                    <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                        <div class="nav-profile-img">
                            <img src="{!! \Illuminate\Support\Facades\Auth::user()->thumbnailUrl !!}" alt="image">
                            <span class="availability-status online"></span>
                        </div>
                        <div class="nav-profile-text">
                            <p class="mb-1 text-black">{!! \Illuminate\Support\Facades\Auth::user()->name !!}</p>
                        </div>
                    </a>
                    <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout mr-2 text-primary"></i> Đăng xuất </a>
                    </div>
                </li>
                <li class="nav-item d-none d-lg-block full-screen-link">
                    <a class="nav-link">
                        <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                    </a>
                </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                <span class="mdi mdi-menu"></span>
            </button>
        </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item nav-profile">
                    <a href="{{ route('admin.users.edit', \Illuminate\Support\Facades\Auth::id()) }}" class="nav-link">
                        <div class="nav-profile-image">
                            <img src="{!! \Illuminate\Support\Facades\Auth::user()->thumbnailUrl !!}" alt="profile">
                            <span class="login-status online"></span>
                            <!--change to offline or busy as needed-->
                        </div>
                        <div class="nav-profile-text d-flex flex-column">
                            <span class="font-weight-bold mb-2">{!! \Illuminate\Support\Facades\Auth::user()->name !!}</span>
                            <span class="text-secondary text-small">{{ \Illuminate\Support\Facades\Auth::user()->roles->last()->name }}</span>
                        </div>
                        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">
                        <span class="menu-title">Thống kê</span>
                        <i class="mdi mdi-home menu-icon"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#li-products" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-title">Quản lý sản phẩm</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-food-fork-drink"></i>
                    </a>
                    <div class="collapse" id="li-products" style="">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.products.index')}}">Danh sách sản phẩm</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.products.create')}}">Thêm sản phẩm</a></li>
                        </ul>
                    </div>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->isSuperAdmin())
                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#li-brands" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-title">Quản lý thương hiệu</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-format-list-bulleted"></i>
                    </a>
                    <div class="collapse" id="li-brands" style="">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.brands.index')}}">Danh sách thương hiệu</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.brands.create')}}">Thêm thương hiệu</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" data-toggle="collapse" href="#li-categories" aria-expanded="false" aria-controls="ui-basic">
                        <span class="menu-title">Quản lý chuyên mục</span>
                        <i class="menu-arrow"></i>
                        <i class="mdi mdi-format-list-bulleted"></i>
                    </a>
                    <div class="collapse" id="li-categories" style="">
                        <ul class="nav flex-column sub-menu">
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.categories.index')}}">Danh sách chuyên mục</a></li>
                            <li class="nav-item"> <a class="nav-link" href="{{route('admin.categories.create')}}">Thêm chuyên mục</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        <span class="menu-title">Danh sách người dùng</span>
                        <i class="mdi mdi-account-multiple menu-icon"></i>
                    </a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.edit', \Illuminate\Support\Facades\Auth::id()) }}">
                        <span class="menu-title">Tài khoản</span>
                        <i class="mdi mdi-account menu-icon"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
            @yield('content')
            <!-- content-wrapper ends -->
            <!-- partial:partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2017 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!-- container-scroller -->
@yield('js')
</body>
</html>
