<header class="main-header" ng-controller="headerPartial">
    <!-- top bar -->
    <div class="top-bar fl-wrap">
        <div class="container">
            <div class="date-holder">
                <span class="date_num"></span>
                <span class="date_mounth"></span>
                <span class="date_year"></span>
            </div>
            <div class="header_news-ticker-wrap">
                <div class="hnt_title">Hot News :</div>
                <div class="header_news-ticker fl-wrap">
                    <ul>
                        @foreach($posts as $p)
                            <li><a href="{{ route('front.blogs', $p->slug) }}">{{ $p->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="n_contr-wrap">
                    <div class="n_contr p_btn"><i class="fas fa-caret-left"></i></div>
                    <div class="n_contr n_btn"><i class="fas fa-caret-right"></i></div>
                </div>
            </div>
            <ul class="topbar-social">
                <li><a href="{{ $config->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="{{ $config->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                <li><a href="{{ $config->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                <li><a href="{{ $config->youtube }}" target="_blank"><i class="fab fa-youtube"></i></a></li>

            </ul>
        </div>
    </div>
    <!-- top bar end -->
    <style>
        :root{ --brand-orange:#EE4110; --ink-700:#2c2c2c; }


        /* Dropdown khung */
        .user-dropdown{
            position:absolute; right:0; top:calc(100% + 10px);
            min-width:220px; background:#fff; border-radius:12px; padding:8px;
            box-shadow:0 12px 30px rgba(0,0,0,.12);
            opacity:0; visibility:hidden; transform:translateY(6px);
            transition:opacity .18s ease, transform .18s ease, visibility .18s;
            z-index:1000;
        }

        /* Hiện dropdown khi hover wrapper hoặc dropdown (để không bị tắt khi rê vào menu) */
        .user-menu:hover .user-dropdown,
        .user-dropdown:hover{
            opacity:1; visibility:visible; transform:translateY(0);
        }

        /* Thẻ user info trên cùng dropdown */
        .user-card{ display:flex; align-items:center; gap:10px; padding:8px; border-radius:10px;
            background:rgba(0,0,0,.03); margin-bottom:6px; }
        .avatar{ border-radius:50%; object-fit:cover; }
        .avatar--large{ width:44px; height:44px; }
        .avatar--initials{
            display:inline-grid; place-items:center; color:#fff; font-weight:700;
            background:linear-gradient(180deg, var(--brand-orange), #ff6a2f);
        }
        .user-card .hello{ font-weight:700; color:var(--ink-700); line-height:1.3; }
        .user-card .email{ font-size:12px; opacity:.7; }

        /* Link trong dropdown */
        .user-dropdown a{
            display:flex; align-items:center; gap:10px; padding:10px; border-radius:10px;
            color:var(--ink-700); text-decoration:none;
        }
        .user-dropdown a:hover{ background:rgba(0,0,0,.05); }
        .user-dropdown .logout{ color:#b42318; }
        .user-dropdown hr{ border:none; height:1px; background:rgba(0,0,0,.08); margin:6px 0; }

    </style>
    <div class="header-inner fl-wrap">
        <div class="container">
            <!-- logo holder  -->
            <a href="{{ route('front.home-page') }}" class="logo-holder"><img src="{{ $config->image->path ?? '' }}" alt=""></a>
            <!-- logo holder end -->
            <div class="search_btn htact show_search-btn"><i class="far fa-search"></i> <span class="header-tooltip">Search</span></div>

            @if($customer)
                @php
                    $full = trim($customer->fullname ?? '');
                    $parts = preg_split('/\s+/', $full, -1, PREG_SPLIT_NO_EMPTY);
                    $initials = count($parts) >= 2
                        ? mb_substr($parts[0],0,1).mb_substr($parts[count($parts)-1],0,1)
                        : (count($parts) === 1 ? mb_substr($parts[0],0,1) : 'U');
                    $displayName = \Illuminate\Support\Str::limit($customer->fullname, 24);
                @endphp

                <div class="user-menu">   {{-- wrapper mới --}}
                    {{-- ▼ GIỮ NGUYÊN KHỐI CŨ --}}
                    <div class="srf_btn htact "><i class="fal fa-user"></i>
                    </div>
                    {{-- ▲ GIỮ NGUYÊN KHỐI CŨ --}}

                    {{-- Dropdown hiển thị khi hover --}}
                    <div class="user-dropdown" role="menu">
                        <div class="user-card">
                            @if(!empty($customer->avatar->path))
                                <img class="avatar avatar--large" src="{{ $customer->avatar->path }}" alt="{{ $customer->fullname }}">
                            @else
                                <img class="avatar avatar--large" src="/site/img/user.png" alt="{{ $customer->fullname }}">
                            @endif
                            <div class="user-meta">
                                <div class="hello">Hi {{ $displayName }}</div>
                                @if(!empty($customer->email))
                                    <div class="email">{{ $customer->email }}</div>
                                @endif
                            </div>
                        </div>

                        <a href="{{ route('front.getProfile') }}#info" role="menuitem"><i class="far fa-user-circle"></i> Tài khoản</a>
                        <a href="{{ route('front.getProfile') }}" role="menuitem"><i class="far fa-bookmark"></i> Bài đã mua</a>
                        <hr>
                        <a href="#" class="logout btn-logout" role="menuitem" >
                            <i class="far fa-sign-out-alt"></i> Đăng xuất
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('front.logout') }}" class="d-none">@csrf</form>
                    </div>
                </div>
            @else
                <div class="srf_btn htact show-reg-form"><i class="fal fa-user"></i> <span class="header-tooltip">Đăng nhập</span></div>

            @endif


            <div class="show-cart sc_btn htact"><i class="fal fa-shopping-bag"></i><span class="show-cart_count"><% cart.count %></span><span class="header-tooltip">Giỏ hàng</span></div>
            <!-- header-search-wrap -->
            <div class="header-search-wrap novis_sarch">
                <div class="widget-inner">
                    <form>
                        <input name="se" id="se" type="text" class="search" placeholder="Nhập từ khóa của bạn..." value="" ng-model="keywords" />
                        <button class="search-submit" id="submit_btn" ng-click="search()"><i class="fa fa-search transition"></i> </button>
                    </form>
                </div>
            </div>
            <!-- header-search-wrap end -->
            <!-- header-cart_wrap  -->
            <div class="header-cart_wrap novis_cart">
                <div class="header-cart_title">Giỏ hàng <span><strong><% cart.count %></strong> sản phẩm</span></div>
                <div class="header-cart_wrap_container fl-wrap">
                    <div class="box-widget-content">
                        <div class="widget-posts fl-wrap">
                            <ol>
                                <li class="clearfix" ng-repeat="item in cart.items">
                                    <a href="#" class="widget-posts-img"><img src="<% item.attributes.image %>" class="respimg" alt=""></a>
                                    <div class="widget-posts-descr">
                                        <a href="#" title=""><% item.name %></a>
                                        <div class="widget-posts-descr_calc clearfix">1 <span>x</span> <% (item.price) | number %>₫</div>
                                    </div>
                                    <div class="clear-cart_button" ng-click="removeItem(item.id)"><i class="far fa-times"></i></div>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
                <div class="header-cart_wrap_total fl-wrap">
                    <div class="header-cart_wrap_total_item">Tổng : <span><% cart.total | number%>₫</span></div>
                </div>
                <div class="header-cart_wrap_footer fl-wrap">
                    <a href="{{ route('cart.index') }}">Xem giỏ hàng</a>
                    <a href="{{ route('cart.checkout') }}">Thanh toán</a>
                </div>
            </div>
            <!-- header-cart_wrap end  -->
            <!-- nav-button-wrap-->
            <div class="nav-button-wrap">
                <div class="nav-button">
                    <span></span><span></span><span></span>
                </div>
            </div>
            <!-- nav-button-wrap end-->
            <!--  navigation -->
            <div class="nav-holder main-menu">
                <nav>
                    <ul>
                        <li><a href="{{ route('front.home-page') }}">Trang chủ</a></li>
                        <li><a href="{{ route('front.abouts') }}">Giới thiệu</a></li>




                        @foreach($postsCategory as $postCategory)
                            <li>
                                <a href="{{ route('front.blogs', $postCategory->slug) }}">{{ $postCategory->name }}
                                    @if($postCategory->childs->count())
                                        <i class="fas fa-caret-down"></i>
                                    @endif
                                </a>
                                @if($postCategory->childs->count())
                                    <ul>
                                        @foreach($postCategory->childs as $child)
                                            <li><a href="{{ route('front.blogs', $child->slug) }}">{{ $child->name }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>

                        @endforeach

                        <li><a href="{{ route('front.contact') }}">Liên hệ</a></li>

                    </ul>
                </nav>
            </div>
            <!-- navigation  end -->
        </div>
    </div>
</header>
