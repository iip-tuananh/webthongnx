@extends('site.layouts.master')
@section('title'){{ $blog->name }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/css/editor-content.css">



@endsection

@section('content')
    <style>
        /* Style gọn, khớp với box-widget có sẵn */
        .post-paycard{border:1px solid #e8edf2;border-radius:12px;padding:14px;background:#fff}
        .post-paycard-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
        .ppc-badge{display:inline-block;font-size:.85rem;padding:6px 10px;border-radius:999px;border:1px solid #e8edf2}
        .ppc-badge.is-free{background:#f1f8f5;color:#0b7a3b;border-color:#d5efe3}
        .ppc-badge.is-paid{background:#fff5f0;color:#b23c17;border-color:#ffd9c9}
        .ppc-title{margin:0;font-size:1.05rem; text-align: left}

        .post-paycard-price{margin:8px 0 12px}
        .ppc-price-row{align-items:flex-end;gap:10px}
        .ppc-price-current{font-weight:700;font-size:1.05rem}
        .ppc-price-old{text-decoration:line-through;color:#9aa3ae}
        .ppc-price-free{font-weight:700;color:#0b7a3b}

        .post-paycard-actions{flex-wrap:wrap;gap:10px;margin-bottom:10px}
        .ppc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:10px;padding:10px 14px;border:1px solid transparent;cursor:pointer;text-decoration:none}
        .ppc-btn-primary{background:#ff6a00;color:#fff}
        .ppc-btn-primary:hover{filter:brightness(.96)}
        .ppc-btn-ghost{background:#fff;border:1px solid #e8edf2;color:#111}
        .ppc-inline-form{display:inline}

        .post-paycard-meta{margin:8px 0 0;padding:10px 2px;border:1px dashed #e8edf2;border-radius:10px;list-style:none}
        .post-paycard-meta li{display:flex;margin:4px 0}
        .post-paycard-meta span{color:#6b7280;min-width:110px}

        @media (max-width:600px){
            .ppc-title{font-size:1rem}
            .ppc-price-current{font-size:1.1rem}
        }

    </style>
    <div class="content" ng-controller="blogPage">
        <div class="breadcrumbs-header fl-wrap">
            <div class="container">
                <div class="breadcrumbs-header_url">
                    <a href="{{ route('front.home-page') }}">Trang chủ</a>
                    <a href="{{ route('front.blogs', $blog->category->slug ?? '') }}">{{ $blog->category->name ?? '' }}</a>
                    <span>{{ $blog->name }}</span>
                </div>
                <div class="scroll-down-wrap">
                    <div class="mousey">
                        <div class="scroller"></div>
                    </div>
                    <span>Scroll Down To Discover</span>
                </div>
            </div>
            <div class="pwh_bg"></div>
        </div>
        <!--section   -->
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <!-- sidebar   -->
                        <div class="sidebar-content fl-wrap fixed-bar">
                            <!-- box-widget -->
                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="box-widget-content">
                                    @include('site.partials.post-paycard', ['blog' => $blog])
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="widget-title">Danh mục</div>
                                <div class="box-widget-content">
                                    <ul class="cat-wid-list">
                                        @foreach($categories as $cate)
                                            <li><a href="{{ route('front.blogs', $cate->slug) }}">{{ $cate->name }}</a><span>{{ $cate->total_posts }}</span></li>
                                        @endforeach
                                    </ul>
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

                        </div>
                        <!-- sidebar  end -->
                    </div>

                    <div class="col-md-9">
                        <div class="main-container fl-wrap fix-container-init">
                            <!-- single-post-header  -->
                            <div class="single-post-header fl-wrap">
                                <a class="post-category-marker" href="category.html">{{ $blog->category->name ?? '' }}</a>
                                <div class="clearfix"></div>
                                <h1>{{ $blog->name }}</h1>
                                <div class="clearfix"></div>
                                <div class="author-link"><a href="author-single.html"><img src="/site/images/avatar/2.jpg" alt="">
                                        <span>By Admin</span></a></div>
                                <span class="post-date"><i class="far fa-clock"></i> {{ \Carbon\Carbon::parse($blog->created)->format('d/m/Y') }}</span>

                            </div>
                            <!-- single-post-header end   -->
                            <!-- single-post-media   -->
                            <div class="single-post-media fl-wrap">
                                <div class="single-slider-wrap fl-wrap">
                                    <div class="single-slider fl-wrap">
                                        <div class="swiper-container">
                                            <div class="swiper-wrapper lightgallery">
                                                <!-- swiper-slide   -->
                                                <div class="swiper-slide hov_zoom">
                                                    <img src="{{ $blog->image->path ?? '' }}" alt="">
                                                    <a href="{{ $blog->image->path ?? '' }}" class="box-media-zoom   popup-image"><i class="fas fa-search"></i></a>
                                                    <span class="post-media_title pmd_vis">© Image Copyrights Title</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="ss-slider-controls2">
                                        <div class="ss-slider-pagination pag-style"></div>
                                    </div>
                                    <div class="ss-slider-cont ss-slider-cont-prev"><i class="fas fa-caret-left"></i></div>
                                    <div class="ss-slider-cont ss-slider-cont-next"><i class="fas fa-caret-right"></i></div>
                                </div>


                            </div>


                    <style>
                        /* Paywall styles */
                        .single-post-content_text.is-locked{position:relative}
                        .paywall-excerpt{
                            max-height: clamp(220px, 40vh, 420px);
                            overflow: hidden;
                            /* tạo fade cuối đoạn preview */
                            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
                            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
                        }
                        .paywall-overlay{
                            position:absolute; inset:auto 0 0 0; /* nằm dưới cùng */
                            display:flex; justify-content:center;
                            background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,.96) 30%, rgba(255,255,255,1));
                            padding: 26px 12px 14px;
                        }
                        .paywall-card{
                            width: min(380px, 100%);
                            border:1px solid #e8edf2; border-radius:12px; background:#fff;
                            padding:14px; text-align:center; box-shadow:0 8px 24px rgba(0,0,0,.06);
                        }
                        .paywall-badge{
                            display:inline-block; padding:5px 10px; border-radius:999px; font-size:.85rem;
                            border:1px solid #e8edf2; margin-bottom:6px
                        }
                        .paywall-badge.is-paid{background:#fff5f0; color:#b23c17; border-color:#ffd9c9}
                        .paywall-badge.is-free{background:#f1f8f5; color:#0b7a3b; border-color:#d5efe3}
                        .paywall-price{margin:4px 0 8px; font-size:1.15rem}
                        .paywall-price .old{margin-left:8px; color:#9aa3ae; text-decoration:line-through}
                        .paywall-actions{display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-top:8px}
                        .pw-btn{display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:10px; border:1px solid transparent; text-decoration:none; cursor:pointer}
                        .pw-btn-primary{background:#ff6a00; color:#fff !important;}
                        .pw-btn-ghost{background:#fff; color:#111; border-color:#e8edf2}
                        @media (max-width: 600px){
                            .paywall-card{padding:12px}
                        }



                        /* đặt chiều cao vùng overlay (có thể chỉnh) */
                        .single-post-content_text.is-locked{ position:relative; --pw-h:120px; }

                        /* phần preview: chừa chỗ bằng padding-bottom = chiều cao overlay */
                        .paywall-excerpt{
                            max-height: clamp(220px, 40vh, 420px);
                            overflow:hidden;
                            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
                            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
                            padding-bottom: var(--pw-h);          /* <<< quan trọng */
                        }

                        /* overlay chỉ chiếm đúng phần đã chừa ở đáy */
                        .paywall-overlay{
                            position:absolute; left:0; right:0; bottom:0;
                            height: var(--pw-h);                  /* <<< khớp với padding-bottom */
                            display:flex; align-items:center; justify-content:center;
                            background: linear-gradient(to bottom,
                            rgba(255,255,255,0),
                            rgba(255,255,255,.96) 45%, #fff 90%);
                            padding: 10px 12px;
                        }

                        /* để click được nút bên trong nhưng không chặn phần preview phía trên */
                        .paywall-overlay{ pointer-events:none; }
                        .paywall-card{ pointer-events:auto; }

                        @media (max-width:600px){
                            .single-post-content_text.is-locked{ --pw-h:140px; }  /* nếu mobile cần cao hơn */
                        }


                    </style>


                            <!-- single-post-media end   -->
                            <!-- single-post-content   -->
                            <div class="single-post-content  fl-wrap">
                                <div class="clearfix"></div>
                                @php
                                    $canRead = (bool)($blog->canAccess ?? false);

                                    // Preview an toàn khi khóa (chỉ text)
                                    use Illuminate\Support\Str;
                                    // 1) Lấy plain text
                                    $raw = strip_tags($blog->body ?? '');

                                    // 2) Decode entities nhiều lượt (xử lý case &amp;ecirc; -> &ecirc; -> ê)
                                    $prev = null; $i = 0;
                                    while ($raw !== $prev && $i < 3) {
                                        $prev = $raw;
                                        $raw  = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                        $i++;
                                    }

                                    // 3) Chuẩn hoá khoảng trắng, thay NBSP
                                    $raw = preg_replace('/\x{00A0}/u', ' ', $raw); // NBSP -> space
                                    $raw = preg_replace('/\s+/u', ' ', $raw);

                                    // 4) Cắt preview
                                    $previewText = Str::words($raw, 120, '…');

                                    // (tuỳ chọn) giá/label
                                    $basePrice  = (int)($blog->price ?? 0);
                                    $isPaid     = $blog->type == 1 ? false : true ;
                                @endphp

                                <div class="single-post-content_text {{ $canRead ? '' : 'is-locked' }} editor-content" id="font_chage">
                                    @if($canRead)
                                        {!! $blog->body !!}
                                    @else
                                        {{-- Preview rút gọn --}}
                                        <div class="paywall-excerpt">
                                            <p>{!! nl2br(($previewText)) !!}</p>
                                        </div>

                                        {{-- Lớp mờ + thông điệp + CTA --}}
                                        <div class="paywall-overlay" style="top: 50px">
                                            <div class="paywall-card">
                                                <span class="paywall-badge is-paid">
                                                   Bài viết trả phí
                                                </span>

                                                <div class="paywall-price">
                                                    <strong>{{ number_format($basePrice) }}₫</strong>
                                                </div>
                                                <p>Vui lòng mua để đọc toàn bộ nội dung.</p>

                                                <div class="paywall-actions">
                                                    @if(! auth('customer')->check())
                                                        <a class="pw-btn pw-btn-primary"
                                                           href="{{ route('front.home-page') }}#login">
                                                            Đăng nhập
                                                        </a>
                                                    @else
                                                        @if($isPaid)
                                                            <form method="post" action="" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="type" value="post">
                                                                <input type="hidden" name="post_id" value="{{ $blog->id }}">
                                                                <button type="button" class="pw-btn pw-btn-primary" ng-click="addToCart({{ $blog->id }})">Thêm vào giỏ</button>
                                                            </form>
                                                        @else
                                                            <a class="pw-btn pw-btn-primary" href="">
                                                                Đọc ngay
                                                            </a>
                                                        @endif
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                <div class="single-post-footer fl-wrap">
                                    <div class="post-single-tags">
                                        <span class="tags-title"><i class="fas fa-tag"></i> Tags : </span>
                                        <div class="tags-widget">
                                            @foreach($blog->tags as $tag)
                                                <a href="{{ route('front.getPostByTag', $tag->slug) }}">{{ $tag->name }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- single-post-content  end   -->
                            <div class="limit-box2 fl-wrap"></div>

                            <!-- post-author-->
                            <!--post-author end-->
                            <div class="more-post-wrap  fl-wrap" style="margin-top: 50px">
                                <div class="pr-subtitle prs_big">Bài viết liên quan</div>
                                <div class="list-post-wrap list-post-wrap_column fl-wrap">
                                    <div class="row">
                                        @foreach($othersBlog as $otherBlog)
                                            <div class="col-md-6">
                                                <!--list-post-->
                                                <div class="list-post fl-wrap">
                                                    <a class="post-category-marker" href="{{ route('front.blogs', $otherBlog->category->slug ?? '') }}">{{ $otherBlog->category->name ?? '' }}</a>
                                                    <div class="list-post-media">
                                                        <a href="{{ route('front.blogDetail', $otherBlog->slug) }}">
                                                            <div class="bg-wrap">
                                                                <div class="bg" data-bg="{{ $otherBlog->image->path ?? '' }}"></div>
                                                            </div>
                                                        </a>
                                                        <span class="post-media_title">&copy; Image Copyrights Title</span>
                                                    </div>
                                                    <div class="list-post-content">
                                                        <h3><a href="{{ route('front.blogDetail', $otherBlog->slug) }}">{{ $otherBlog->name }}</a></h3>
                                                        <span class="post-date"><i class="far fa-clock"></i>{{ \Illuminate\Support\Carbon::parse($otherBlog->created_at)->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                                <!--list-post end-->
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="limit-box fl-wrap"></div>
            </div>
        </section>
        <!-- section end -->

    </div>


@endsection

@push('scripts')
    <script>
        app.controller('blogPage', function ($rootScope, $scope, cartItemSync, $interval) {
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




        })
    </script>
@endpush
