<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        {{-- <div class="image">
            <img src="img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> --}}
        <div class="info">
            @if(Auth::user()->type == App\Model\Common\User::SUPER_ADMIN)
            <a href="#" class="d-block" style="color: #fd7e14">Xin chào: {{ Auth::user()->account_name }}</a>
            @else
            <a href="#" class="d-block" style="color: #fd7e14">{{ App\Model\Common\User::find(Auth::user()->id)->name }}</a>
            @endif
        </div>
    </div>
    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-flat" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item has-treeview menu-open">
                <a href="{{route('dash')}}" class="nav-link {{ request()->is('admin/common/dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        Dashboard
                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview  {{ request()->is('admin/abouts') || request()->is('admin/abouts/*')
|| request()->is('admin/abouts') || request()->is('admin/abouts/*')  || request()->is('admin/achievements')
 ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-info"></i>
                    <p>
                        Cấu hình trang chủ
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('achievements.index') }}" class="nav-link {{ Request::routeIs('achievements.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Khối thống kê các con số</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('abouts.edit') }}" class="nav-link {{ Request::routeIs('abouts.edit') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Khối Lý do chọn chúng tôi</p>
                        </a>
                    </li>


{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('whyUs.edit') }}" class="nav-link {{ Request::routeIs('whyUs.edit') ? 'active' : '' }}">--}}
{{--                            <i class="far fas  fa-angle-right nav-icon"></i>--}}
{{--                            <p>Khối Lý do chọn chúng tôi</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}


                </ul>
            </li>




{{--            <li class="nav-item has-treeview  {{ request()->is('admin/about-page/edit') || request()->is('admin/about-page/') || request()->is('admin/about-page/edit') || request()->is('admin/about-page/edit/*') ? 'menu-open' : '' }} ">--}}

{{--                <a href="#" class="nav-link {{ request()->is('admin/about-page/edit') ? 'active' : '' }}">--}}
{{--                    <i class="nav-icon fas fa-info"></i>--}}
{{--                    <p>--}}
{{--                        Trang giới thiệu--}}
{{--                        <i class="fas fa-angle-left right"></i>--}}
{{--                    </p>--}}
{{--                </a>--}}
{{--                <ul class="nav nav-treeview">--}}
{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('aboutPage.edit') }}" class="nav-link {{ Request::routeIs('aboutPage.edit') ? 'active' : '' }}">--}}
{{--                            <i class="far fas  fa-angle-right nav-icon"></i>--}}
{{--                            <p>Chỉnh sửa trang giới thiệu</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}


            <li class="nav-item has-treeview  {{ request()->is('admin/posts') || request()->is('admin/posts/*') || request()->is('admin/category-special')
|| request()->is('admin/post-categories') || request()->is('admin/post-categories/*')|| request()->is('admin/tags')  ? 'menu-open' : '' }} ">

                <a href="#" class="nav-link {{ request()->is('admin/posts') || request()->is('admin/posts/*') || request()->is('admin/post-categories') || request()->is('admin/post-categories/*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-blog"></i>
                    <p>
                        Blog
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('category_special.index') }}" class="nav-link {{ Request::routeIs('category_special.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục đặc biệt</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('PostCategory.index') }}" class="nav-link {{ Request::routeIs('PostCategory.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Post.index') }}" class="nav-link {{ Request::routeIs('Post.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Quản lý bài viết</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('tags.index') }}" class="nav-link {{ Request::routeIs('tags.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Quản lý thẻ tag</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item has-treeview {{
      request()->is('admin/orders*') ||
      request()->is('admin/customers*')
        ? 'menu-open'
        : ''
    }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-exchange-alt"></i>
                    <p>
                        Quản lý giao dịch
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <!-- Đơn thuê -->
                    <!-- Đơn đặt mua -->
                    <li class="nav-item">
                        <a href="{{ route('orders.index') }}"
                           class="nav-link {{ Request::routeIs('orders.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Đơn hàng</p>
                        </a>
                    </li>
                    <!-- Khách hàng -->
                    <li class="nav-item">
                        <a href="{{ route('customers.index') }}"
                           class="nav-link {{ Request::routeIs('customers.index') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Khách hàng</p>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item has-treeview  {{ request()->is('admin/stores') ||  request()->is('admin/banner-page')
||  request()->is('admin/banners') || request()->is('admin/origins') || request()->is('admin/manufacturers/*') || request()->is('admin/policies/*') || request()->is('admin/policies')
|| request()->is('admin/attributes') ? 'menu-open' : '' }} ">

                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-newspaper"></i>
                    <p>
                        Danh mục khác
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('banners.index') }}" class="nav-link {{ Request::routeIs('banners.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục banner trang chủ</p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="{{ route('Review.index') }}" class="nav-link {{ Request::routeIs('Review.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>
                                Đánh giá khách hàng
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('contacts.index') }}" class="nav-link {{ Request::routeIs('contacts.index') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Danh mục khách hàng liên hệ</p>
                        </a>
                    </li>

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('policies.index') }}" class="nav-link {{ Request::routeIs('policies.index') ? 'active' : '' }}">--}}
{{--                            <i class="far fas  fa-angle-right nav-icon"></i>--}}
{{--                            <p>Quản lý chính sách bán hàng</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}

                </ul>
            </li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                        Người dùng
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ route('User.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Tài khoản</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="{{ route('User.create') }}" class="nav-link">
                            <i class="far fas fa-angle-right nav-icon"></i>
                            <p>Tạo tài khoản</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('Role.index') }}" class="nav-link">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Chức vụ</p>
                        </a>
                    </li> --}}
                </ul>
            </li>

            <li class="nav-item has-treeview  {{ request()->is('uptek/configs') || request()->is('uptek/customer-levels') || request()->is('uptek/accumulate-point/*') ? 'menu-open' : '' }} ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        Cấu hình hệ thống
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('Config.edit') }}" class="nav-link  {{ Request::routeIs('Config.edit') ? 'active' : '' }}">
                            <i class="far fas  fa-angle-right nav-icon"></i>
                            <p>Cấu hình chung</p>
                        </a>
                    </li>

{{--                    <li class="nav-item">--}}
{{--                        <a href="{{ route('configStatistic.index') }}" class="nav-link {{ Request::routeIs('configStatistic.index') ? 'active' : '' }}">--}}
{{--                            <i class="far fas  fa-angle-right nav-icon"></i>--}}
{{--                            <p>Cấu hình số liệu thống kê</p>--}}
{{--                        </a>--}}
{{--                    </li>--}}
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
