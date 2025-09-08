<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('site.partials.head')
    @yield('css')
</head>

<body ng-app="App">

<div id="main">
    <!-- progress-bar  -->
    <div class="progress-bar-wrap">
        <div class="progress-bar color-bg"></div>
    </div>

    @include('site.partials.header')

    <div id="wrapper">
        @yield('content')

        @include('site.partials.footer')

    </div>



    <!-- cookie-info-bar end -->
    <!--register form -->
    <div class="main-register-container" ng-controller="registerForm">
        <div class="reg-overlay close-reg-form"></div>
        <div class="main-register-holder">
            <div class="main-register-wrap fl-wrap">
                <div class="main-register_bg">
                    <div class="bg-wrap">
                        <div class="bg par-elem "  data-bg="/site/images/bg/1.jpg"></div>
                        <div class="overlay"></div>
                    </div>
                    <div class="mg_logo"><img src="/site/images/logo2.png" alt=""></div>
                </div>
                <div class="main-register tabs-act fl-wrap">
                    <ul class="tabs-menu">
                        <li class="current"><a href="#tab-1"><i class="fal fa-sign-in-alt"></i> Đăng nhập</a></li>
                        <li><a href="#tab-2"><i class="fal fa-user-plus"></i> Đăng ký</a></li>
                    </ul>
                    <div class="close-modal close-reg-form"><i class="fal fa-times"></i></div>
                    <!--tabs -->
                    <div id="tabs-container">
                        <div class="tab">
                            <!--tab -->
                            <div id="tab-1" class="tab-content first-tab">
                                <div class="custom-form">
                                    <form name="registerform" id="form-login">
                                        <label>Email<span>*</span> </label>
                                        <input name="email" type="text" onClick="this.select()" value="">
                                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errorsLogin && errorsLogin['email']">
                                                                <% errorsLogin['email'][0] %>
                                                            </span>
                                        </div>

                                        <label>Mật khẩu <span>*</span> </label>
                                        <input name="password" type="password" onClick="this.select()" value="">
                                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errorsLogin && errorsLogin['password']">
                                                                <% errorsLogin['password'][0] %>
                                                            </span>
                                        </div>

                                        <div class="filter-tags">
                                            <input id="check-a" type="checkbox" name="check" checked>
                                            <label for="check-a">Nhớ tài khoản</label>
                                        </div>
{{--                                        <div class="lost_password">--}}
{{--                                            <a href="#">Lost Your Password?</a>--}}
{{--                                        </div>--}}
                                        <div class="clearfix"></div>
                                        <button type="button" class="log-submit-btn color-bg" ng-click="submitLogin()"><span>Đăng nhập</span></button>
                                    </form>
                                </div>
                            </div>
                            <!--tab end -->
                            <!--tab -->
                            <div class="tab">
                                <div id="tab-2" class="tab-content">
                                    <div class="custom-form">
                                        <form name="registerform" id="form-register" class="main-register-form" id="main-register-form2">
                                            <label>Họ tên <span>*</span> </label>
                                            <input name="fullname" type="text" onClick="this.select()" value="">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['fullname']">
                                                                <% errors['fullname'][0] %>
                                                            </span>
                                            </div>

                                            <label>Email <span>*</span></label>
                                            <input name="email" type="text" onClick="this.select()" value="">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['email']">
                                                                <% errors['email'][0] %>
                                                            </span>
                                            </div>

                                            <label>Mật khẩu  <span>*</span></label>
                                            <input name="password" type="password" onClick="this.select()" value="">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['password']">
                                                                <% errors['password'][0] %>
                                                            </span>
                                            </div>

                                            <label>Nhập lại mật khẩu  <span>*</span></label>
                                            <input name="password-rep" type="password" onClick="this.select()" value="">
                                            <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['password-rep']">
                                                                <% errors['password-rep'][0] %>
                                                            </span>
                                            </div>

                                            <button type="button" class="log-submit-btn color-bg" ng-click="registerSubmit()"><span>Đăng ký</span></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!--tab end -->
                        </div>
                        <!--tabs end -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="/site/js/jquery.min.js"></script>
<script src="/site/js/plugins.js"></script>
<script src="/site/js/scripts.js"></script>

    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        window.USER_AVATAR_URL = "{{ $customer->avatar->path ?? '/site/img/user.png' }}";
    </script>

    @include('site.partials.angular_mix')


    <script>
        app.controller('registerForm', function ($rootScope, $scope, $interval) {
            $scope.errors = [];
            $scope.errorsLogin = [];
            $scope.registerSubmit = function () {
                var url = "{{route('front.submitRegister')}}";
                var data = jQuery('#form-register').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            jQuery('#form-register')[0].reset();
                            window.location.href = response.redirect_url;
                            $scope.errors = [];
                        } else {
                            $scope.errors = response.errors;
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

            $scope.submitLogin = function () {
                var url = "{{route('front.submitLogin')}}";
                var data = jQuery('#form-login').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = response.redirect_url;
                            $scope.errorsLogin = [];
                        } else {
                            $scope.errorsLogin = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

        })
    </script>

    <script>
        app.controller('headerPartial', function ($rootScope, $scope, cartItemSync, $interval, $window) {
            $scope.cart = cartItemSync;
            $scope.avatarPreviewUrl = window.USER_AVATAR_URL;

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };


            $scope.changeQty = function (qty, item) {
                updateCart(qty, item)
            }

            function updateCart(qty, item) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('cart.update.item')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: item.id,
                        variant_id: item.attributes.variant_id,
                        qty: qty
                    },
                    beforeSend: function() {
                        jQuery('.loading-spin').show();
                        // showOverlay();
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.countItem = response.count;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        jQuery('.loading-spin').hide();
                        // hideOverlay();
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function (post_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{route('cart.remove.item')}}",
                    data: {
                        post_id: post_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            if ($scope.total == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = response.count;

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }



            $scope.search = function () {
                if (!$scope.keywords || !$scope.keywords.trim()) {
                    alert('Vui lòng nhập từ khóa tìm kiếm!');
                    return;
                }

                // Xây URL cơ bản
                var url = '/tim-kiem?keywords=' + encodeURIComponent($scope.keywords.trim());

                // Điều hướng
                $window.location.href = url;
            };

            $('.btn-logout').on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: '{{ route("front.logout") }}',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN
                    },
                    success: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    },
                    error: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    }
                });
            });


        });


        app.factory('cartItemSync', function ($interval) {
            var cart = {items: null, total: null};

            cart.items = @json($cartItems);
            cart.count = {{$cartItems->sum('quantity')}};
            cart.total = {{$totalPriceCart}};

            return cart;
        });

    </script>

    @stack('scripts')
</body>

</html>
