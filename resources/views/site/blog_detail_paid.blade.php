@extends('site.layouts.master')
@section('title'){{ $blog->name }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')



@endsection

@section('content')
    <style>
        /* Style gọn, khớp với box-widget có sẵn */
        .post-paycard{border:1px solid #e8edf2;border-radius:12px;padding:14px;background:#fff}
        .post-paycard-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
        .ppc-badge{display:inline-block;font-size:.85rem;padding:6px 10px;border-radius:999px;border:1px solid #e8edf2}
        .ppc-badge.is-free{background:#f1f8f5;color:#0b7a3b;border-color:#d5efe3}
        .ppc-badge.is-paid{background:#fff5f0;color:#b23c17;border-color:#ffd9c9}
        .ppc-title{margin:0;font-size:1.05rem}

        .post-paycard-price{margin:8px 0 12px}
        .ppc-price-row{display:flex;align-items:flex-end;gap:10px}
        .ppc-price-current{font-weight:700;font-size:1.25rem}
        .ppc-price-old{text-decoration:line-through;color:#9aa3ae}
        .ppc-price-free{font-weight:700;color:#0b7a3b}

        .post-paycard-actions{display:flex;flex-wrap:wrap;gap:10px;margin-bottom:10px}
        .ppc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:10px;padding:10px 14px;border:1px solid transparent;cursor:pointer;text-decoration:none}
        .ppc-btn-primary{background:#ff6a00;color:#fff}
        .ppc-btn-primary:hover{filter:brightness(.96)}
        .ppc-btn-ghost{background:#fff;border:1px solid #e8edf2;color:#111}
        .ppc-inline-form{display:inline}

        .post-paycard-meta{margin:8px 0 0;padding:10px 12px;border:1px dashed #e8edf2;border-radius:10px;list-style:none}
        .post-paycard-meta li{display:flex;gap:8px;margin:4px 0}
        .post-paycard-meta span{color:#6b7280;min-width:110px}

        @media (max-width:600px){
            .ppc-title{font-size:1rem}
            .ppc-price-current{font-size:1.1rem}
        }

    </style>
    <div class="content">
        <div class="breadcrumbs-header fl-wrap">
            <div class="container">
                <div class="breadcrumbs-header_url">
                    <a href="#">Home</a><span>Blog List style</span>
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
                                <div class="widget-title">Categories</div>
                                <div class="box-widget-content">
                                    <ul class="cat-wid-list">
                                        <li><a href="#">Science</a><span>3</span></li>
                                        <li><a href="#">Politics</a> <span>6</span></li>
                                        <li><a href="#">Technology</a> <span>12</span></li>
                                        <li><a href="#">Sports</a> <span>4</span></li>
                                        <li><a href="#">Business</a> <span>22</span></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="widget-title">Popular Tags</div>
                                <div class="box-widget-content">
                                    <div class="tags-widget">
                                        <a href="#">Science</a>
                                        <a href="#">Politics</a>
                                        <a href="#">Technology</a>
                                        <a href="#">Business</a>
                                        <a href="#">Sports</a>
                                        <a href="#">Food</a>
                                    </div>
                                </div>
                            </div>
                            <!-- box-widget  end -->
                            <!-- box-widget -->

                            <!-- box-widget  end -->
                            <!-- box-widget -->
                            <div class="box-widget fl-wrap">
                                <div class="box-widget-content">
                                    <!-- content-tabs-wrap -->
                                    <div class="content-tabs-wrap tabs-act tabs-widget fl-wrap">
                                        <div class="content-tabs fl-wrap">
                                            <ul class="tabs-menu fl-wrap no-list-style">
                                                <li class="current"><a href="#tab-popular"> Popular News </a></li>
                                                <li><a href="#tab-resent">Resent News</a></li>
                                            </ul>
                                        </div>
                                        <!--tabs -->
                                        <div class="tabs-container">
                                            <!--tab -->
                                            <div class="tab">
                                                <div id="tab-popular" class="tab-content first-tab">
                                                    <div class="post-widget-container fl-wrap">
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/1.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">How to start Home education.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 25 may 2022</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 12</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 654</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/2.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">The secret to moving this   screening.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 13 april 2021</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 6</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 1227</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/3.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">Fall ability to keep Congress on rails.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 02 December 2021</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 12</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 654</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--tab  end-->
                                            <!--tab -->
                                            <div class="tab">
                                                <div id="tab-resent" class="tab-content">
                                                    <div class="post-widget-container fl-wrap">
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/5.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">Magpie nesting zone sites.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 05 april 2021</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 16</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 727</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/6.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">Locals help create whole new community.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 22 march 2021</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 31</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 63</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
                                                        <!-- post-widget-item -->
                                                        <div class="post-widget-item fl-wrap">
                                                            <div class="post-widget-item-media">
                                                                <a href="post-single.html"><img src="/site/images/all/thumbs/7.jpg"  alt=""></a>
                                                            </div>
                                                            <div class="post-widget-item-content">
                                                                <h4><a href="post-single.html">Tennis season still to proceed.</a></h4>
                                                                <ul class="pwic_opt">
                                                                    <li><span><i class="far fa-clock"></i> 06 December 2021</span></li>
                                                                    <li><span><i class="far fa-comments-alt"></i> 05</span></li>
                                                                    <li><span><i class="fal fa-eye"></i> 145</span></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- post-widget-item end -->
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





                            <!-- single-post-media end   -->
                            <!-- single-post-content   -->
                            <div class="single-post-content spc_column fl-wrap">
                                <div class="single-post-content_column">
                                    <div class="share-holder ver-share fl-wrap">
                                        <div class="share-title">Share This <br> Article:</div>
                                        <div class="share-container  isShare"></div>
                                    </div>
                                </div>
                                <div class="fs-wrap smpar fl-wrap">
                                    <div class="fontSize"><span class="fs_title">Font size: </span><input type="text" class="rage-slider" data-step="1" data-min="12" data-max="15" value="12"></div>
                                    <div class="show-more-snopt smact"><i class="fal fa-ellipsis-v"></i></div>
                                    <div class="show-more-snopt-tooltip">
                                        <a href="#comments" class="custom-scroll-link"> <i class="fas fa-comment-alt"></i> Write a Comment</a>
                                        <a href="#"> <i class="fas fa-exclamation-triangle"></i> Report </a>
                                    </div>
                                    <a class="print-btn" href="javascript:window.print()" data-microtip-position="bottom"><span>Print</span><i class="fal fa-print"></i></a>
                                </div>
                                <div class="clearfix"></div>
                                <div class="single-post-content_text" id="font_chage">
                                    {!! $blog->body !!}
                                </div>
                                <div class="single-post-footer fl-wrap">
                                    <div class="post-single-tags">
                                        <span class="tags-title"><i class="fas fa-tag"></i> Tags : </span>
                                        <div class="tags-widget">
                                            <a href="#">Science</a>
                                            <a href="#">Technology</a>
                                            <a href="#">Business</a>
                                            <a href="#">Lifestyle</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- single-post-content  end   -->
                            <div class="limit-box2 fl-wrap"></div>

                            <!-- post-author-->
                            <!--post-author end-->
                            <div class="more-post-wrap  fl-wrap">
                                <div class="pr-subtitle prs_big">Related Posts</div>
                                <div class="list-post-wrap list-post-wrap_column fl-wrap">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!--list-post-->
                                            <div class="list-post fl-wrap">
                                                <a class="post-category-marker" href="category.html">Science</a>
                                                <div class="list-post-media">
                                                    <a href="post-single.html">
                                                        <div class="bg-wrap">
                                                            <div class="bg" data-bg="/site/images/all/16.jpg"></div>
                                                        </div>
                                                    </a>
                                                    <span class="post-media_title">&copy; Image Copyrights Title</span>
                                                </div>
                                                <div class="list-post-content">
                                                    <h3><a href="post-single.html">How to start Home renovation.</a></h3>
                                                    <span class="post-date"><i class="far fa-clock"></i>  05 April 2022</span>
                                                </div>
                                            </div>
                                            <!--list-post end-->
                                        </div>
                                        <div class="col-md-6">
                                            <!--list-post-->
                                            <div class="list-post fl-wrap">
                                                <a class="post-category-marker" href="category.html">Sports</a>
                                                <div class="list-post-media">
                                                    <a href="post-single.html">
                                                        <div class="bg-wrap">
                                                            <div class="bg" data-bg="/site/images/all/24.jpg"></div>
                                                        </div>
                                                    </a>
                                                    <span class="post-media_title">&copy; Image Copyrights Title</span>
                                                </div>
                                                <div class="list-post-content">
                                                    <h3><a href="post-single.html">Warriors face season defining clash</a></h3>
                                                    <span class="post-date"><i class="far fa-clock"></i> 11 March 2022</span>
                                                </div>
                                            </div>
                                            <!--list-post end-->
                                        </div>
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
        <!-- section  -->
        <div class="gray-bg ad-wrap fl-wrap">
            <div class="content-banner-wrap">
                <img src="/site/images/all/banner.jpg" class="respimg" alt="">
            </div>
        </div>
        <!-- section end -->
    </div>


@endsection

@push('scripts')
    <script>
    </script>
@endpush
