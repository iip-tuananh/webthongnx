@php
    $basePrice  = (int)($blog->price ?? 0);
    $isPaid     = $blog->type == 1 ? false : true ;
    $finalPrice = $basePrice;
@endphp

<div class="post-paycard">
    <div class="post-paycard-head">
        <span class="ppc-badge {{ $isPaid ? 'is-paid' : 'is-free' }}">
            {{ $isPaid ? 'Trả phí' : 'Miễn phí' }}
        </span>
        <h5 class="ppc-title">{{ $blog->name ?? 'Bài viết' }}</h5>
    </div>

    <div class="post-paycard-price">
        @if(!$isPaid)
            <span class="ppc-price-free">Miễn phí</span>
        @else
            <div class="ppc-price-row">
                <span class="ppc-price-current">{{ number_format($finalPrice) }}₫</span>
            </div>
        @endif
    </div>

    <div class="post-paycard-actions">
        @if(! $customer)
            @if($isPaid)
                <a class="ppc-btn ppc-btn-primary"
                   href="{{ route('front.home-page') }}#login">
                    Đăng nhập để {{ $isPaid ? 'mua' : 'đọc' }}
                </a>
            @endif


        @else
            @if(!$isPaid)
            @else

                @if($blog->canAccess)
                    <button type="button" class="ppc-btn ppc-btn-primary">Đã sở hữu</button>
                @else
                    <form method="post" action="" class="ppc-inline-form">
                        @csrf
                        <input type="hidden" name="type" value="post">
                        <input type="hidden" name="post_id" value="{{ $blog->id }}">
                        <button type="button" class="ppc-btn ppc-btn-primary" ng-click="addToCart({{ $blog->id }})">Thêm vào giỏ hàng</button>
                    </form>
                @endif

            @endif
        @endguest

        {{-- Gợi ý: nếu đã mua rồi, hiện "Đọc ngay" --}}
        {{--                                            @auth--}}
        {{--                                                @if(isset($blog->owned) && $blog->owned)--}}
        {{--                                                    <a class="ppc-btn ppc-btn-ghost" href="{{ route('posts.show', $blog->slug ?? $blog->id) }}">--}}
        {{--                                                        Đã mua • Đọc ngay--}}
        {{--                                                    </a>--}}
        {{--                                                @endif--}}
        {{--                                            @endauth--}}
    </div>

    {{-- Thông tin phụ (tuỳ chọn) --}}
    <ul class="post-paycard-meta">
        @if(!empty($blog->category->name))
            <li><span>Danh mục:</span> <strong>{{ $blog->category->name }}</strong></li>
        @endif
        <li><span>Tác giả:</span> <strong>Admin</strong></li>

        @if(!empty($blog->reading_time))
            <li><span>Thời gian đọc:</span> <strong>15 phút</strong></li>
        @endif
    </ul>
</div>
