@extends('site.layouts.master')
@section('title')Tin tức - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')

@endsection


@section('content')
    <div class="content">
        <div class="breadcrumbs-header fl-wrap">
            <div class="container">
                <div class="breadcrumbs-header_url">
                    <a href="{{ route('front.home-page') }}">Trang chủ</a>
                    <span>Tag "{{ $tag->name }}"</span>
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
                    <div class="col-md-8">
                        <div class="main-container fl-wrap fix-container-init">
                            <div class="section-title">
                                <h2>Tag "{{$tag->name}}"</h2>
                                <h4></h4>
                                <div class="steader_opt steader_opt_abs">
                                    <select name="filter" id="list" data-placeholder="Persons" class="style-select no-search-select">

                                        <option data-url="{{ request()->fullUrlWithQuery(['sort'=>'date_desc','page'=>1]) }}"
                                            {{ request('sort') === 'date_desc' ? 'selected' : '' }}>Mới nhất</option>
                                        <option data-url="{{ request()->fullUrlWithQuery(['sort'=>'date_asc','page'=>1]) }}"
                                            {{ request('sort') === 'date_asc' ? 'selected' : '' }}>Cũ nhất</option>
                                        <option data-url="{{ request()->fullUrlWithQuery(['sort'=>'name_asc','page'=>1]) }}"
                                            {{ request('sort') === 'name_asc' ? 'selected' : '' }}>Tên A-Z</option>
                                        <option data-url="{{ request()->fullUrlWithQuery(['sort'=>'name_desc','page'=>1]) }}"
                                            {{ request('sort') === 'name_desc' ? 'selected' : '' }}>Tên Z-A</option>

                                    </select>
                                </div>
                            </div>
                            <div class="list-post-wrap">
                                @foreach($posts as $post)
                                    <div class="list-post fl-wrap">
                                        <div class="list-post-media">
                                            <a href="post-single.html">
                                                <div class="bg-wrap">
                                                    <div class="bg" data-bg="{{ $post->image->path ?? '' }}"></div>
                                                </div>
                                            </a>
                                            <span class="post-media_title">&copy; Image Copyrights Title</span>
                                        </div>
                                        <div class="list-post-content">
                                            <a class="post-category-marker" href="{{ route('front.blogs', $post->category->slug ?? '') }}">{{ $post->category->name ?? '' }}</a>
                                            <h3><a href="{{ route('front.blogDetail', $post->slug) }}">{{ $post->name }}</a></h3>
                                            <span class="post-date"><i class="far fa-clock"></i> {{ \Illuminate\Support\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                                            <p>
                                                {{ $post->intro }}
                                            </p>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                            <div class="clearfix"></div>

                            <!--pagination-->
                            {{ $posts->links('site.pagination.paginate2') }}
                            <!--pagination end-->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- sidebar   -->
                        <div class="sidebar-content fl-wrap fixed-bar">
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
                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="widget-title">Follow Us</div>
                                <div class="box-widget-content">
                                    <div class="social-widget">
                                        <a href="#" target="_blank" class="facebook-soc">
                                            <i class="fab fa-facebook-f"></i>
                                            <span class="soc-widget-title">Likes</span>
                                            <span class="soc-widget_counter">2640</span>
                                        </a>
                                        <a href="#" target="_blank" class="twitter-soc">
                                            <i class="fab fa-twitter"></i>
                                            <span class="soc-widget-title">Followers</span>
                                            <span class="soc-widget_counter">1456</span>
                                        </a>
                                        <a href="#" target="_blank" class="youtube-soc">
                                            <i class="fab fa-youtube"></i>
                                            <span class="soc-widget-title">Followers</span>
                                            <span class="soc-widget_counter">1456</span>
                                        </a>
                                        <a href="#" target="_blank" class="instagram-soc">
                                            <i class="fab fa-instagram"></i>
                                            <span class="soc-widget-title">Followers</span>
                                            <span class="soc-widget_counter">1456</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- box-widget  end -->
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
                        </div>
                        <!-- sidebar  end -->
                    </div>
                </div>
                <div class="limit-box fl-wrap"></div>
            </div>
        </section>
        <!-- section end -->
        <!-- section  -->

        <!-- section end -->
    </div>


@endsection

@push('scripts')
    <script>
        $(document).on('change', '#list', function () {
            var url = $(this).find('option:selected').data('url') || '';
            if (url) window.location.href = url;
        });

    </script>
@endpush
