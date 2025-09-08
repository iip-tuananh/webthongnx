@extends('site.layouts.master')
@section('title'){{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/swiper@9/swiper-bundle.min.css">

@endsection

@section('content')
    <style>
        :root{
            --brand-orange: #EE4110;   /* chỉnh theo màu nút của bạn */
            --brand-orange-strong: #C7360E;
            --brand-orange-weak: #FFE3D7;
            --ink-dark: #2c2c2c;
            --white: #fff;
        }


        /* Overlay badge trên ảnh */
        .post-badge{
            position:absolute; top:10px; left:10px;
            display:inline-flex; align-items:center; gap:8px;
            padding:6px 10px; border-radius:999px;
            font-size:14px; font-weight:700; line-height:1;
            box-shadow: 0 6px 14px rgba(0,0,0,.12);
            backdrop-filter: blur(2px);
        }
        .post-badge i{ font-size:12px; }

        /* FREE: nền sáng, viền cam nhạt – hợp tin tức */
        .post-badge.is-free{
            background: #0da306;
            color: #fff;
            border: 1px dashed rgba(238, 65, 16, .45);
        }

        /* PAID: nền cam đậm + chữ trắng */
        .post-badge.is-paid{
            background: linear-gradient(180deg, var(--brand-orange), #ff6a2f);
            color: var(--white);
            border: none;
            text-shadow: 0 1px 0 rgba(0,0,0,.15);
        }


    </style>

    <style>
        .post-widget-item .post-widget-item-media{ position:relative; }
        .post-widget-item .pw-badge{
            position:absolute; left:6px; bottom:6px;
            display:inline-flex; align-items:center; gap:6px;
            padding:3px 6px; border-radius:999px;
            font-size:10px; font-weight:700; line-height:1;
            white-space:nowrap; box-shadow:0 4px 10px rgba(0,0,0,.12);
            backdrop-filter: blur(2px);
        }
        .post-widget-item .pw-badge i{ font-size:10px; }

        /* Free */
        .post-widget-item .pw-badge.is-free{
            background: #0da306;
            color: #fff;
            border: 1px dashed rgba(238,65,16,.45);
        }

        /* Paid */
        .post-widget-item .pw-badge.is-paid{
            background: linear-gradient(180deg, var(--brand-orange), #ff6a2f);
            color: var(--white);
            border:none; text-shadow:0 1px 0 rgba(0,0,0,.15);
        }

        /* Nếu quá chật ở màn nhỏ: chỉ hiện icon, ẩn text */
        @media (max-width: 420px){
            .post-widget-item .pw-badge{ padding:3px 4px; }
            .post-widget-item .pw-badge span{ display:none; } /* nếu bạn để text trong <span> */
        }
    </style>
    <div class="content" ng-controller="homePage">
        <!-- hero-slider-wrap     -->
        <div class="hero-slider-wrap fl-wrap">
            <!-- hero-slider-container     -->
            <div class="hero-slider-container multi-slider fl-wrap full-height">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <!-- swiper-slide -->
                        @foreach($banners as $banner)
                            <div class="swiper-slide">
                                <div class="bg-wrap">
                                    <div class="bg" data-bg="{{ $banner->image->path ?? '' }}" data-swiper-parallax="40%"></div>
                                    <div class="overlay"></div>
                                </div>
                                <div class="hero-item fl-wrap">

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="fs-slider_btn color-bg fs-slider-button-prev"><i class="fas fa-caret-left"></i></div>
                <div class="fs-slider_btn color-bg fs-slider-button-next"><i class="fas fa-caret-right"></i></div>
            </div>
            <!-- hero-slider-container  end   -->
            <!-- hero-slider_controls-wrap   -->
            <div class="hero-slider_controls-wrap">
                <div class="container">
                    <div class="hero-slider_controls-list multi-slider_control">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">

                            </div>
                        </div>
                    </div>
                    <div class="multi-pag"></div>
                </div>
            </div>
            <!-- hero-slider_controls-wrap end  -->
            <div class="slider-progress-bar act-slider">

            </div>
        </div>
        <!-- hero-slider-wrap  end   -->
        <!-- section   -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="main-container fl-wrap fix-container-init">
                            <div class="section-title">
                                <h2><% getCategoryCurrent(currentCateId).name %></h2>
                                <h4><% getCategoryCurrent(currentCateId).intro %></h4>
                                <div class="ajax-nav">
                                    <ul>
                                        @foreach($postCategories as $postCate)
                                            <li><a href="javascript:void(0)" ng-click="getPostByCate({{ $postCate->id }})"
                                                   ng-class="{'current_page': currentCateId == {{ $postCate->id }} }"
                                                >{{ $postCate->name }}</a></li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                            <div class="ajax-wrapper fl-wrap">
                                <div class="ajax-loader"><img src="/site/images/loading.gif" alt=""/></div>
                                <div id="ajax-content" class="fl-wrap">
                                    <div class="ajax-inner fl-wrap" style="opacity: 1;">
                                        <div class="list-post-wrap">

                                            <div class="list-post fl-wrap" ng-repeat="post in posts">
                                                <div class="list-post-media">
                                                    <a href="/<% post.slug %>">
                                                        <div class="bg-wrap">
                                                            <div class="bg" data-bg="<% post.image ? post.image.path : '' %>"
                                                                 ng-style="post.image && {'background-image': 'url(' + post.image.path + ')'}"
                                                                 ></div>
                                                        </div>
                                                    </a>

                                                    <span class="post-badge"
                                                          ng-class="{'is-free': post.type == 1, 'is-paid': post.type == 2}">
                                                              <i class="fas"
                                                                 ng-class="post.type==1 ? 'fa-newspaper' : (post.type==2 && ! post.access ? 'fa-lock' : '')">
                                                              </i>
                                                              <span ng-if="post.type==1">Miễn phí</span>
                                                              <span ng-if="post.type==2 && ! post.access"><% post.price ? (post.price | currency:'₫':0) : 'Liên hệ' %></span>
                                                              <span ng-if="post.type==2 && post.access">Đã sở hữu</span>
                                                            </span>

                                                    <span class="post-media_title">© Image Copyrights Title</span>
                                                </div>
                                                <div class="list-post-content">
                                                    <a class="post-category-marker" href="#"><% post.category ? post.category.name : '' %></a>
                                                    <h3><a href="/<% post.slug %>"><% post.name %></a></h3>
                                                    <span class="post-date"><i class="far fa-clock"></i><% formartDate(post.created_at) | date:'dd/MM/yyyy' %></span>
                                                    <p>
                                                        <% post.intro %>
                                                    </p>
                                                </div>


                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>




                            <style>
                                /* ========== Scope & tokens ========== */
                                #kpi-counters{ --ink:#0e0e10; --muted:#596066; --accent:#f59e0b; --teal:#0f766e; --line:#edf0f2; }
                                #kpi-counters, #kpi-counters *{ box-sizing: border-box; }

                                /* ========== Layout ========== */
                                #kpi-counters .kpi__container{ max-width:1220px; margin:0 auto; padding:26px 16px; }
                                #kpi-counters .kpi__grid{
                                    list-style:none; margin:0; padding:0;
                                    display:grid; gap:clamp(16px,3vw,40px);
                                    grid-template-columns: repeat(4, minmax(0,1fr));
                                    align-items:center;
                                }

                                /* ========== Item ========== */
                                #kpi-counters .kpi__item{ display:flex; flex-direction:column; gap:10px; }

                                /* Top row: icon + number */
                                #kpi-counters .kpi__top{ display:flex; align-items:center; gap:14px; min-height:56px; }
                                #kpi-counters .kpi__icon{
                                    width:56px; height:56px; display:grid; place-items:center; border-radius:12px;
                                    border:1px solid var(--line); background:#ffffff;
                                    box-shadow:0 8px 20px rgba(2,8,23,.06);
                                }
                                #kpi-counters .kpi__icon img{ width:40px; height:40px; object-fit:contain; display:block; }

                                /* Number + plus */
                                #kpi-counters .kpi__number{ display:flex; align-items:baseline; gap:6px; }
                                #kpi-counters .kpi__num{
                                    font-weight:900; color:var(--accent);
                                    font-size: clamp(28px, 4vw, 24px); line-height:1;
                                }
                                #kpi-counters .kpi__plus{
                                    font-weight:900; color:var(--accent); font-size: clamp(22px, 2.2vw, 32px);
                                }

                                /* Label */
                                #kpi-counters .kpi__label{
                                    margin:0;
                                    font-size:.85rem; letter-spacing:.12em; text-transform:uppercase;
                                    color:#0f1621; font-weight:800;
                                }

                                /* ========== Responsive ========== */
                                @media (max-width: 992px){
                                    #kpi-counters .kpi__grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
                                }
                                @media (max-width: 520px){
                                    #kpi-counters .kpi__grid{ grid-template-columns: 1fr 1fr; gap:18px 12px; }
                                    #kpi-counters .kpi__icon{ width:50px; height:50px; }
                                    #kpi-counters .kpi__icon img{ width:36px; height:36px; }
                                }

                            </style>
                            <section id="kpi-counters" class="kpi" style="padding-top: 0; padding-bottom: 20px">
                                <div class="kpi__container">

                                    <ul class="kpi__grid">

                                        @foreach($achievements as $achievement)
                                            <li class="kpi__item">
                                                <div class="kpi__top">
          <span class="kpi__icon">
            <img src="{{ $achievement->image->path ?? '' }}" alt="" width="48" height="48" loading="lazy" decoding="async">
          </span>
                                                    <div class="kpi__number">
                                                        <span class="kpi__num" data-target="{{ $achievement->title }}" data-duration="1400">0</span>
                                                        <span class="kpi__plus">+</span>
                                                    </div>
                                                </div>
                                                <p class="kpi__label">{{ $achievement->content }}</p>
                                            </li>

                                        @endforeach


                                    </ul>

                                </div>
                            </section>



                            <div class="clearfix"></div>
                            <div class="section-title sect_dec">
                                <h2>Bài viết mới nhất</h2>
                            </div>
                            <div class="grid-post-wrap">
                                <div class="more-post-wrap  fl-wrap">
                                    <div class="list-post-wrap list-post-wrap_column fl-wrap">
                                        <div class="row">
                                            @foreach($postsRecent as $postRecent)
                                                <div class="col-md-6">
                                                    <!--list-post-->
                                                    <div class="list-post fl-wrap">
{{--                                                        <a class="post-category-marker" href="{{ route('front.blogs', $postRecent->category->slug ?? '') }}">--}}
{{--                                                            {{ $postRecent->category->name ?? '' }}--}}
{{--                                                        </a>--}}
                                                        <div class="list-post-media">
                                                            <a href="{{ route('front.blogDetail', $postRecent->slug) }}">
                                                                <div class="bg-wrap">
                                                                    <div class="bg" data-bg="{{ $postRecent->image->path ?? '' }}"></div>
                                                                </div>
                                                            </a>

                                                            <span class="post-badge {{ ($postRecent->type ?? 1) == 1 ? 'is-free' : 'is-paid' }}">
                                                                <i class="fas {{ ($postRecent->type ?? 1) == 1 ? 'fa-newspaper' : (! $postRecent->access ? 'fa-lock' : '') }}"></i>
                                                                @if(($postRecent->type ?? 1) == 1)
                                                                    Miễn phí
                                                                @else
                                                                    @if(! $postRecent->access)
                                                                        {{ isset($postRecent->price) && $postRecent->price > 0
                                                                                           ? number_format($postRecent->price, 0, ',', '.') . '₫'
                                                                                               : 'Liên hệ' }}
                                                                    @else
                                                                        Đã sở hữu
                                                                    @endif


                                                                @endif
                                                            </span>

                                                            <span class="post-media_title">&copy; Image Copyrights Title</span>
                                                        </div>
                                                        <div class="list-post-content list-post-content-1">
{{--                                                            <a class="post-category-marker" href="{{ route('front.blogs', $postRecent->category->slug ?? '') }}">--}}
{{--                                                                {{ $postRecent->category->name ?? '' }}--}}
{{--                                                            </a>--}}
                                                            <h3 ><a href="{{ route('front.blogDetail', $postRecent->slug) }}">{{ $postRecent->name }}</a></h3>
                                                            <span class="post-date"><i class="far fa-clock"></i>
                                                                {{ \Illuminate\Support\Carbon::parse($postRecent->created_at)->format('d/m/Y') }}
                                                            </span>


                                                        </div>
                                                    </div>
                                                    <!--list-post end-->
                                                </div>
                                            @endforeach


                                        </div>
                                    </div>
                                </div>

                            </div>
                            <a href="{{ route('front.blogs') }}" class="dark-btn fl-wrap"> Xem tất cả </a>




                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- sidebar   -->
                        <div class="sidebar-content fl-wrap fix-bar">
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="box-widget-content">
                                    <!-- content-tabs-wrap -->
                                    <div class="content-tabs-wrap tabs-act tabs-widget fl-wrap">
                                        <div class="content-tabs fl-wrap">
                                            <ul class="tabs-menu fl-wrap no-list-style">
                                                <li class="current"><a href="#tab-popular"> Bài viết phổ biến </a></li>
                                                <li><a href="#tab-resent">Bài viết mới nhất</a></li>
                                            </ul>
                                        </div>
                                        <!--tabs -->
                                        <div class="tabs-container">
                                            <!--tab -->
                                            <div class="tab">
                                                <div id="tab-popular" class="tab-content first-tab">
                                                    <div class="post-widget-container fl-wrap">
                                                        <!-- post-widget-item -->
                                                        @foreach($popularPosts as $popularPost)
                                                            <div class="post-widget-item fl-wrap">
                                                                <div class="post-widget-item-media">
                                                                    <a href="{{ route('front.blogDetail', $popularPost->slug) }}"><img src="{{ $popularPost->image->path ?? '' }}"  alt=""></a>


                                                                    <span class="pw-badge {{ ($popularPost->type ?? 1) == 1 ? 'is-free' : 'is-paid' }}">
                                                                <i class="fas {{ ($popularPost->type ?? 1) == 1 ? 'fa-newspaper' : (! $popularPost->access ? 'fa-lock' : '') }}"></i>
                                                                @if(($popularPost->type ?? 1) == 1)
                                                                            Miễn phí
                                                                        @else
                                                                            @if(! $popularPost->access)
                                                                                {{ isset($popularPost->price) && $popularPost->price > 0
                                                                                                   ? number_format($popularPost->price, 0, ',', '.') . '₫'
                                                                                                       : 'Liên hệ' }}
                                                                            @else
                                                                                Đã sở hữu
                                                                            @endif
                                                                  @endif
                                                            </span>




                                                                </div>
                                                                <div class="post-widget-item-content">
                                                                    <h4><a href="{{ route('front.blogDetail', $popularPost->slug) }}">{{ $popularPost->name }}</a></h4>
                                                                    <ul class="pwic_opt">
                                                                        <li><span><i class="far fa-clock"></i>{{ \Illuminate\Support\Carbon::parse($popularPost->created_at)->format('d/m/Y') }}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            <!--tab  end-->
                                            <!--tab -->
                                            <div class="tab">
                                                <div id="tab-resent" class="tab-content">
                                                    <div class="post-widget-container fl-wrap">
                                                        <!-- post-widget-item -->
                                                        @foreach($postsRecent as $postRecent)
                                                            <div class="post-widget-item fl-wrap">
                                                                <div class="post-widget-item-media">
                                                                    <a href="{{ route('front.blogDetail', $postRecent->slug) }}"><img src="{{ $postRecent->image->path ?? '' }}"  alt=""></a>

                                                                    <span class="pw-badge {{ ($postRecent->type ?? 1) == 1 ? 'is-free' : 'is-paid' }}">
                                                                <i class="fas {{ ($postRecent->type ?? 1) == 1 ? 'fa-newspaper' : (! $postRecent->access ? 'fa-lock' : '') }}"></i>
                                                                @if(($postRecent->type ?? 1) == 1)
                                                                            Miễn phí
                                                                        @else
                                                                            @if(! $postRecent->access)
                                                                                {{ isset($postRecent->price) && $postRecent->price > 0
                                                                                                   ? number_format($postRecent->price, 0, ',', '.') . '₫'
                                                                                                       : 'Liên hệ' }}
                                                                            @else
                                                                                Đã sở hữu
                                                                            @endif
                                                                        @endif
                                                            </span>

                                                                </div>
                                                                <div class="post-widget-item-content">
                                                                    <h4><a href="{{ route('front.blogDetail', $postRecent->slug) }}">{{ $postRecent->name }}</a></h4>
                                                                    <ul class="pwic_opt">
                                                                        <li><span><i class="far fa-clock"></i>{{ \Illuminate\Support\Carbon::parse($postRecent->created_at)->format('d/m/Y') }}</span></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            <!--tab end-->
                                        </div>
                                        <!--tabs end-->
                                    </div>
                                    <!-- content-tabs-wrap end -->
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->

                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="widget-title">Theo dõi chúng tôi</div>
                                <div class="box-widget-content">
                                    <div class="social-widget">
                                        <a href="{{ $config->facebook }}" target="_blank" class="facebook-soc">
                                            <i class="fab fa-facebook-f"></i>
                                            <span class="soc-widget-title">Facebook</span>
                                        </a>
                                        <a href="{{ $config->twitter }}" target="_blank" class="twitter-soc">
                                            <i class="fab fa-twitter"></i>
                                            <span class="soc-widget-title">Twitter</span>
                                        </a>
                                        <a href="{{ $config->youtube }}" target="_blank" class="youtube-soc">
                                            <i class="fab fa-youtube"></i>
                                            <span class="soc-widget-title">Youtube</span>
                                        </a>
                                        <a href="{{ $config->instagram }}" target="_blank" class="instagram-soc">
                                            <i class="fab fa-instagram"></i>
                                            <span class="soc-widget-title">Instagram</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="widget-title">Tags</div>
                                <div class="box-widget-content">
                                    <div class="tags-widget">
                                        @foreach($tags as $tag)
                                            <a href="{{ route('front.getPostByTag', $tag->slug) }}">{{ $tag->name }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->

                            <!-- box-widget  end -->
                        </div>
                        <!-- sidebar  end -->
                    </div>
                </div>
                <div class="limit-box fl-wrap"></div>
            </div>
        </section>







        <style>
            /* ===== Scope & tokens ===== */
            #whychoose-v2 { --ink:#0e0e10; --muted:#5d6166; --brand:#0f766e; --accent:#f59e0b; --surface:#fff; --line:#edf0f2; }
            #whychoose-v2, #whychoose-v2 * { box-sizing: border-box; }
            #whychoose-v2 { isolation:isolate; }

            /* ===== Layout ===== */
            #whychoose-v2 .why2__container{ max-width:1220px; margin:0 auto; padding:24px 16px; }
            #whychoose-v2 .why2__grid{
                display:grid; align-items:center;
                grid-template-columns: minmax(0,1.05fr) minmax(0,1fr);
                gap:clamp(24px,4vw,48px);
            }

            /* ===== Left ===== */
            #whychoose-v2 .why2__eyebrow{
                margin:0 0 10px; letter-spacing:.16em; text-transform:uppercase; font-weight:800; color:var(--brand);
            }
            #whychoose-v2 .why2__title{
                margin:0 0 12px; color:var(--ink); font-weight:900;
                font-size:clamp(26px,3.2vw,34px); line-height:1.15;
            }
            #whychoose-v2 .why2__lead{ margin:0 0 22px; color:var(--muted); }

            #whychoose-v2 .why2__list{ list-style:none; margin:0; padding:0; display:grid; gap:18px; }
            #whychoose-v2 .why2__item{
                display:grid; grid-template-columns:56px 1fr; gap:14px; align-items:flex-start;
                background:var(--surface); border:1px solid var(--line); border-radius:14px; padding:12px 14px;
            }
            #whychoose-v2 .why2__icon{
                width:56px; height:56px; display:grid; place-items:center; border-radius:14px;
                border:2px solid var(--accent); background:#fffdfa; overflow:hidden; padding:8px;
            }
            #whychoose-v2 .why2__icon img{ width:100%; height:100%; object-fit:contain; display:block; }
            #whychoose-v2 .why2__item-title{ margin:2px 0 4px; font-size:1.05rem; font-weight:800; color:#111827; text-align: left }
            #whychoose-v2 .why2__item-desc{ margin:0; color:#4b5563; }

            /* ===== Right (1 image) ===== */
            #whychoose-v2 .why2__media{ position:relative; }
            #whychoose-v2 .why2__photo{
                position:relative; overflow:hidden; border-radius:16px; background:#f3f4f6; box-shadow:0 18px 40px rgba(2,8,23,.12);
                /*aspect-ratio: 4 / 3; !* đảm bảo không bị cắt khi chưa tải ảnh *!*/
                border:6px solid #fff;
            }
            #whychoose-v2 .why2__photo img{
                width:100%; height:100%; object-fit:cover; display:block;
            }

            /* ===== Responsive ===== */
            @media (max-width: 992px){
                #whychoose-v2 .why2__container{ padding:42px 16px; }
                #whychoose-v2 .why2__grid{ grid-template-columns:1fr; }
                #whychoose-v2 .why2__media{ order:-1; margin-bottom:8px; }
                #whychoose-v2 .why2__photo{ aspect-ratio: 16 / 10; border-width:4px; }
            }
            @media (max-width: 640px){
                #whychoose-v2 .why2__icon{ width:48px; height:48px; border-radius:12px; padding:6px; }
                #whychoose-v2 .why2__item{ grid-template-columns:52px 1fr; padding:10px 12px; }
                #whychoose-v2 .why2__photo{ aspect-ratio: 16 / 11; }
            }

            /* ===== Optional hover ===== */
            @media (hover:hover){
                #whychoose-v2 .why2__item:hover{ border-color:#e7e2d9; box-shadow:0 6px 20px rgba(2,8,23,.06); }
            }



            /* màu cho icon tích */
            #whychoose-v2 { --ok:#16a34a; --ok-bg:#e8f7ee; }

            /* ghi đè style icon ảnh cũ */
            #whychoose-v2 .why2__icon--check{
                width:56px; height:56px;
                display:grid; place-items:center;
                padding:0; border:0; background:transparent; border-radius:50%;
                filter: drop-shadow(0 4px 10px rgba(2,8,23,.08));
            }
            #whychoose-v2 .why2__icon--check .why2__tick{
                width:100%; height:100%; display:block;
            }

            /* mobile thu nhỏ icon chút */
            @media (max-width:640px){
                #whychoose-v2 .why2__icon--check{ width:48px; height:48px; }
            }

            /* (tuỳ chọn) hiệu ứng hover nhẹ */
            @media (hover:hover){
                #whychoose-v2 .why2__item:hover .why2__icon--check{
                    transform: translateY(-1px);
                }
            }

        </style>

        <!-- section end -->

        <section id="whychoose-v2" class="why2" style="padding-top: 0;padding-bottom: 0">
            <div class="why2__container">
                <div class="why2__grid">

                    <!-- LEFT -->
                    <div class="why2__content">
                        <p class="why2__eyebrow">{{ $about->sub_title }}</p>
                        <h2 class="why2__title">{{ $about->title }}</h2>
                        <p class="why2__lead">{{ $about->intro }}</p>

                        <ul class="why2__list">
                            @if ($about->results && count($about->results))
                                @foreach ($about->results as $key => $why)
                                    <li class="why2__item">
  <span class="why2__icon why2__icon--check" aria-hidden="true">
    <svg viewBox="0 0 48 48" class="why2__tick">
      <!-- nền tròn dịu -->
      <circle cx="24" cy="24" r="22" fill="var(--ok-bg)"/>
        <!-- viền tròn -->
      <circle cx="24" cy="24" r="22" fill="none" stroke="var(--ok)" stroke-width="2"/>
        <!-- dấu tích -->
      <path d="M15 24l6 6 12-12" fill="none" stroke="var(--ok)" stroke-width="4"
            stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </span>

                                        <div class="why2__txt">
                                            <h3 class="why2__item-title">{{ $why['title'] }}</h3>
                                            <p class="why2__item-desc">{{ $why['content'] }}</p>
                                        </div>
                                    </li>

                                @endforeach
                            @endif



                        </ul>
                    </div>

                    <!-- RIGHT: ONE PHOTO -->
                    <div class="why2__media">
                        <figure class="why2__photo">
                            <img src="{{ $about->image->path ?? '' }}" alt="Đội ngũ kỹ sư tại công trình" width="960" height="720" loading="lazy" decoding="async">
                        </figure>
                    </div>

                </div>
            </div>
        </section>







        <!-- section   -->
        <!-- section end -->
        <!-- section  -->
        @foreach($categoriesSpecial as $categorySpecial)
            @php
                $postsSpecial = $categorySpecial->posts;
                $firstPost = $postsSpecial->first();
                $postsSpec = $postsSpecial->slice(1)->values();

            @endphp
            <section>
                <div class="container">
                    <div class="section-title sect_dec">
                        <h2>{{ $categorySpecial->name }}</h2>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="list-post-wrap list-post-wrap_column list-post-wrap_column_fw">
                                <!--list-post-->
                                <div class="list-post fl-wrap">
{{--                                    <a class="post-category-marker" href="{{ route('front.blogs', $firstPost->category->slug ?? '') }}">{{ $firstPost->category->name ?? '' }}</a>--}}
                                    <div class="list-post-media">
                                        <a href="{{ route('front.blogDetail', $firstPost->slug) }}">
                                            <div class="bg-wrap">
                                                <div class="bg" data-bg="{{ $firstPost->image->path }}"></div>
                                            </div>
                                        </a>


                                        <span class="post-badge {{ (($firstPost->type ?? 1) == 1) ? 'is-free' : 'is-paid' }}">
                                                <i class="fas {{ ($firstPost->type ?? 1) == 1 ? 'fa-newspaper' : (! $firstPost->access ? 'fa-lock' : '') }}"></i>
                                                @if(($firstPost->type ?? 1) == 1)
                                                                                    Miễn phí
                                                                                @else
                                                @if(! $firstPost->access)
                                                    {{ isset($firstPost->price) && $firstPost->price > 0
                                                                       ? number_format($firstPost->price, 0, ',', '.') . '₫'
                                                                           : 'Liên hệ' }}
                                                @else
                                                    Đã sở hữu
                                                @endif
                                                                                @endif
                                            </span>






                                        <span class="post-media_title">&copy; Image Copyrights Title</span>
                                    </div>
                                    <div class="list-post-content">
                                        <h3><a href="{{ route('front.blogDetail', $firstPost->slug) }}">{{ $firstPost->name }}  </a></h3>
                                        <span class="post-date"><i class="far fa-clock"></i>{{ \Carbon\Carbon::parse($firstPost->created_at)->format('d/m/Y') }}</span>
                                        <p>
                                            {{ $firstPost->intro }}
                                        </p>

                                    </div>
                                </div>
                                <!--list-post end-->
                            </div>
                            <a href="{{ route('front.home-page') }}" class="dark-btn fl-wrap"> Xem tất cả </a>
                        </div>
                        <div class="col-md-7">
                            <div class="picker-wrap-container fl-wrap">
                                <div class="picker-wrap-controls">
                                    <ul class="fl-wrap">
                                        <li><span class="pwc_up"><i class="fas fa-caret-up"></i></span></li>
                                        <li><span class="pwc_pause"><i class="fas fa-pause"></i></span></li>
                                        <li><span class="pwc_down"><i class="fas fa-caret-down"></i></span></li>
                                    </ul>
                                </div>
                                <div class="picker-wrap fl-wrap">
                                    <div class="list-post-wrap  fl-wrap">
                                        <!--list-post-->
                                        @foreach($postsSpec as $postSpec)
                                            <div class="list-post fl-wrap">
                                                <div class="list-post-media">
                                                    <a href="{{ route('front.blogDetail', $postSpec->slug) }}">
                                                        <div class="bg-wrap">
                                                            <div class="bg" data-bg="{{ $postSpec->image->path ?? '' }}"></div>
                                                        </div>
                                                    </a>

                                                    {{-- BADGE overlay --}}

                                                    <span class="post-badge {{ (($postSpec->type ?? 1) == 1) ? 'is-free' : 'is-paid' }}">
                                                <i class="fas {{ ($postSpec->type ?? 1) == 1 ? 'fa-newspaper' : (! $postSpec->access ? 'fa-lock' : '') }}"></i>
                                                @if(($postSpec->type ?? 1) == 1)
                                                            Miễn phí
                                                        @else
                                                            @if(! $postSpec->access)
                                                                {{ isset($postSpec->price) && $postSpec->price > 0
                                                                                   ? number_format($postSpec->price, 0, ',', '.') . '₫'
                                                                                       : 'Liên hệ' }}
                                                            @else
                                                                Đã sở hữu
                                                            @endif
                                                        @endif
                                            </span>
                                                    <span class="post-media_title">&copy; Image Copyrights Title</span>
                                                </div>
                                                <div class="list-post-content">
                                                    <a class="post-category-marker" href="{{ route('front.blogs', $postSpec->category->slug ?? '') }}">{{ $postSpec->category->name ?? '' }}</a>
                                                    <h3><a href="{{ route('front.blogDetail', $postSpec->slug) }}">{{ $postSpec->name }}</a></h3>
                                                    <span class="post-date"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($postSpec->created_at)->format('d/m/Y') }}</span>
                                                    <p>{{ $postSpec->intro }}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="controls-limit fl-wrap"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="limit-box"></div>
            </section>




        @endforeach

        <!-- section end -->
        <!-- section -->

        <style>
            /* ===== Scope & tokens ===== */
            #feedback-swiper{ --ink:#0f1621; --muted:#6b7280; --card:#fff; --line:#eef2f6; --accent:#f97316; --wave:#f5f7f9; }
            #feedback-swiper, #feedback-swiper *{ box-sizing: border-box; }
            #feedback-swiper .fb2__container{ max-width:1220px; margin:0 auto; padding:0px 16px; }

            /* Swiper base */
            #feedback-swiper .fb2__swiper{ overflow: visible; } /* để thấy drop-shadow */
            #feedback-swiper .swiper-wrapper{ align-items: stretch; }
            #feedback-swiper .swiper-slide{ height: auto; }      /* cho card cao bằng nhau */

            /* Card */
            #feedback-swiper .fb2__card{
                height: 100%;
                position: relative;
                display: flex; align-items: center; gap: 18px;
                padding: 18px 22px;
                background: var(--card);
                border: 1px solid var(--line);
                border-radius: 14px;
                box-shadow: 0 10px 28px rgba(2,8,23,.10);
                overflow: hidden;
            }
            #feedback-swiper .fb2__card::after{
                content:""; position:absolute; left:0; right:0; bottom:0; height:64px; z-index:0;
                background: url("data:image/svg+xml;utf8,\
<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'>\
<path d='M0 44C200 86 400 6 600 44s400-18 600 6V120H0Z' fill='%23f5f7f9'/>\
</svg>") bottom/100% 100% no-repeat;
                pointer-events:none;
            }

            /* Avatar */
            #feedback-swiper .fb2__avatar{ flex:0 0 76px; width:76px; height:76px; border-radius:50%; overflow:hidden; box-shadow:0 6px 16px rgba(2,8,23,.12); }
            #feedback-swiper .fb2__avatar img{ width:100%; height:100%; object-fit:cover; display:block; }

            /* Texts */
            #feedback-swiper .fb2__body{ position:relative; z-index:1; }
            #feedback-swiper .fb2__quote{ margin:0 0 10px; color:var(--muted); line-height:1.6; }
            #feedback-swiper .fb2__name{ display:inline-block; font-style:normal; color:var(--accent); font-weight:800; }

            /* Swiper controls */
            #feedback-swiper .swiper-pagination-bullets .swiper-pagination-bullet{
                background:#d1d5db; opacity:1; width:8px; height:8px; margin:0 4px !important; }
            #feedback-swiper .swiper-pagination-bullet-active{ background:var(--accent); }
            #feedback-swiper .swiper-button-prev,
            #feedback-swiper .swiper-button-next{
                width:38px; height:38px; border-radius:999px; border:1px solid #e5e7eb;
                box-shadow:0 8px 20px rgba(2,8,23,.08);
                --swiper-navigation-size:18px; color:#111827;
            }
            #feedback-swiper .swiper-button-prev:after,
            #feedback-swiper .swiper-button-next:after{ font-size: var(--swiper-navigation-size); }
            #feedback-swiper .swiper-button-prev{ left:-6px; }
            #feedback-swiper .swiper-button-next{ right:-6px; }

            /* Responsive tweaks */
            @media (max-width: 640px){
                #feedback-swiper .fb2__card{ padding:14px 16px; gap:14px; }
                #feedback-swiper .fb2__avatar{ width:60px; height:60px; }
            }
            /* Không cho tràn ra ngoài */
            #feedback-swiper .fb2__container{ overflow: hidden; }
            #feedback-swiper .fb2__swiper{ overflow: hidden; width:100%; } /* bỏ overflow:visible cũ */

            /* Slide cao bằng nhau, không tràn */
            #feedback-swiper .swiper-wrapper{ align-items: stretch; }
            #feedback-swiper .swiper-slide{ height:auto; display:flex; }

            /* Đưa nút điều hướng vào trong, tránh vượt biên */
            #feedback-swiper .swiper-button-prev{ left: 8px; }
            #feedback-swiper .swiper-button-next{ right: 8px; }

            /* (tuỳ) Thu nhỏ padding section để không bị “ảo giác tràn” */
            #feedback-swiper .fb2__container{ padding-left:16px; padding-right:16px; }

        </style>
        <!-- section end -->
        <!-- section  -->


        <section id="feedback-swiper" class="fb2" style="padding-top: 0">
            <div class="fb2__container">
                <div class="section-title sect_dec">
                    <h2>Từ khách hàng</h2>
                    <h4>Những đánh giá, cảm nhận của bạn giúp chúng tôi cải thiện chất lượng dịch vụ</h4>
                </div>
                <div class="swiper fb2__swiper">
                    <div class="swiper-wrapper">
                        @foreach($feedbacks ?? [
                          (object)['name'=>'Trà Nguyễn','content'=>'Mình bán hàng online nên rất hay đặt hàng qua đây, chất lượng tốt, giá ổn định và giao nhanh.','avatar'=>asset('images/avatars/a1.jpg')],
                          (object)['name'=>'Thu Trang','content'=>'Mình thường order từ nước ngoài, nhờ dịch vụ ở đây mà chi phí tốt và nhanh hơn.','avatar'=>asset('images/avatars/a2.jpg')],
                          (object)['name'=>'Bảo Long','content'=>'Tư vấn rõ ràng, giao đúng hẹn, sẽ còn ủng hộ.','avatar'=>asset('images/avatars/a3.jpg')],
                        ] as $fb)
                            @foreach($feedbacks as $feedback)
                                <div class="swiper-slide">
                                    <article class="fb2__card">
                                        <div class="fb2__avatar">
                                            <img src="{{ $feedback->image->path ?? '' }}" alt="Ảnh" loading="lazy" decoding="async">
                                        </div>
                                        <div class="fb2__body">
                                            <blockquote class="fb2__quote">{{ $feedback->message }}</blockquote>
                                            <cite class="fb2__name">{{ $feedback->name }}</cite> <br>
                                            <cite class="fb2__name">{{ $feedback->position }}</cite>
                                        </div>
                                    </article>
                                </div>

                            @endforeach


                        @endforeach
                    </div>

                    <!-- Pagination + arrows -->
                    <div class="swiper-pagination"></div>
{{--                    <div class="swiper-button-prev"></div>--}}
{{--                    <div class="swiper-button-next"></div>--}}
                </div>
            </div>
        </section>

        <!-- section end -->
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            new Swiper('.fb2__swiper', {
                speed: 600,
                grabCursor: true,
                keyboard: { enabled: true },
                pagination: { el: '#feedback-swiper .swiper-pagination', clickable: true },
                navigation: {
                    nextEl: '#feedback-swiper .swiper-button-next',
                    prevEl: '#feedback-swiper .swiper-button-prev'
                },
                // Mặc định mobile 1 card và căn giữa
                slidesPerView: 1,
                spaceBetween: 18,
                centeredSlides: true,
                centeredSlidesBounds: true,   // không lố ở 2 mép
                watchOverflow: true,

                breakpoints: {
                    // >= 640px: đúng 2 card, căn giữa, không tràn
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 24,
                        centeredSlides: true,
                        centeredSlidesBounds: true
                    },
                    // >= 1200px: vẫn 2 card, khoảng cách rộng hơn
                    1200:{
                        slidesPerView: 2,
                        spaceBetween: 32,
                        centeredSlides: true,
                        centeredSlidesBounds: true
                    }
                }
            });
        });
    </script>



    <script>
        // Chạy sau khi DOM sẵn sàng
        $(function () {
            function openLoginModal() {
                $(".main-register-container").fadeIn(1);
                $(".main-register-wrap").addClass("vis_mr");
                // (tuỳ chọn) khoá scroll nền:
                // $("html").addClass("no-scroll");
            }

            function checkHashAndOpen() {
                var h = (window.location.hash || "").toLowerCase();
                if (h === "#login") {
                    openLoginModal();
                    // (tuỳ chọn) xoá #login khỏi URL để tránh mở lại khi back/refresh:
                    // history.replaceState(null, "", window.location.pathname + window.location.search);
                }
            }

            // 1) Kiểm tra ngay khi load trang
            checkHashAndOpen();

            // 2) Nếu hash thay đổi trong khi đang ở trang (SPA/anchor link)
            $(window).on("hashchange", checkHashAndOpen);

            // 3) Bắt các link có href kết thúc bằng #login để mở modal ngay, không cuộn trang
            $(document).on("click", 'a[href$="#login"]', function (e) {
                e.preventDefault();
                // đặt hash -> sẽ kích hoạt checkHashAndOpen qua sự kiện hashchange
                if (window.location.hash !== "#login") {
                    window.location.hash = "login";
                } else {
                    // nếu đã là #login thì mở luôn
                    openLoginModal();
                }
            });
        });
    </script>

    <script>
        (function(){
            const counters = document.querySelectorAll('#kpi-counters .kpi__num');
            if (!counters.length) return;

            function animate(el){
                if (el.dataset.done) return;           // tránh chạy lại
                const end = parseInt(el.dataset.target || '0', 10);
                const dur = parseInt(el.dataset.duration || '1200', 10);
                const start = 0;
                const startTime = performance.now();

                function tick(now){
                    const p = Math.min((now - startTime) / dur, 1);
                    const eased = 1 - Math.pow(1 - p, 3);        // easeOutCubic
                    const val = Math.round(start + (end - start) * eased);
                    // format theo vi-VN
                    el.textContent = val.toLocaleString('vi-VN');
                    if (p < 1) requestAnimationFrame(tick);
                    else el.dataset.done = "1";
                }
                requestAnimationFrame(tick);
            }

            // Trigger khi thấy trong viewport
            if ('IntersectionObserver' in window){
                const io = new IntersectionObserver((entries)=>{
                    entries.forEach(entry=>{
                        if (entry.isIntersecting) {
                            animate(entry.target);
                            io.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.4 });
                counters.forEach(el=>io.observe(el));
            } else {
                // Fallback cũ: chạy luôn
                counters.forEach(animate);
            }
        })();
    </script>



    <script>
        app.controller('homePage', function ($rootScope, $scope, cartItemSync, $interval) {
            $scope.cart = cartItemSync;

            $scope.addToCart = function (postId) {
                url = "{{route('cart.add.item', ['postId' => 'postId'])}}";
                url = url.replace('postId', postId);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'qty': 1
                    },
                    success: function (response) {
                        if (response.success) {
                            $interval.cancel($rootScope.promise);
                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Sản phẩm đã được thêm vào giỏ hàng');
                        } else {
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.toastr('Thao tác thất bại !');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }



            $scope.getPostByCate = function (cateId) {
                var $loader = $('.ajax-loader');
                $scope.currentCateId = cateId;
                $.ajax({
                    type: 'GET',
                    url: "/get-post-by-cate?cate_id="+cateId,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    beforeSend: function () {
                        $loader.stop(true, true).fadeIn(100);
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.posts = response.data;
                            console.log($scope.posts)
                            $scope.$applyAsync();
                        } else {
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $loader.stop(true, true).fadeOut(100);
                    }
                });
            }

            $scope.postCategories = @json($postCategories ?? []);

            $scope.getCategoryCurrent = function (currentCateId) {
                var items = Array.isArray($scope.postCategories) ? $scope.postCategories : [];
                if (currentCateId == null || items.length === 0) return null;

                var target = String(currentCateId);
                for (var i = 0; i < items.length; i++) {
                    var it = items[i];
                    if (it && String(it.id) === target) return it;
                }
                return null;
            };

            @php
                $cats = array_values($postCategories->toArray() ?? []);
                $pick = $cats[0] ?? ($cats[1] ?? null);
                $id = data_get($pick, 'id');
            @endphp
            @if($id)
                $scope.getPostByCate({{ (int)$id }});
            @endif

            $scope.formartDate = function (date) {
                return new Date(date.replace(' ', 'T'));
            }

        })
    </script>

@endpush
