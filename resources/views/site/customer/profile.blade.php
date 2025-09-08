@extends('site.layouts.master')
@section('title')
    {{ $config->web_title }}
@endsection
@section('description')
    {{ strip_tags(html_entity_decode($config->introduction)) }}
@endsection
@section('image')
    {{@$config->image->path ?? ''}}
@endsection

@section('css')

@endsection

@section('content')

    <div class="content" ng-controller="profilePage">
        <!--section   -->
        <div class="breadcrumbs-header fl-wrap">
            <div class="container">
                <div class="breadcrumbs-header_url">
                    <a href="#">Home</a><span>About</span>
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
        <!-- section end  -->
        <!--section   -->
        <section>
            <section class="account-page">
                <div class="container">
                    <div class="account-grid">
                        <!-- SIDEBAR -->
                        <aside class="account-aside">
                            <div class="user-card">
                                <div class="avatar-user">
                                    <img
                                         ng-src="<% avatarPreviewUrl %>"
                                         alt="Avatar">
                                    <input id="avatar-input" type="file" accept="image/*" file-model="form.avatar" style="display:none">

                                    <button class="avatar-edit" type="button" title="Đổi ảnh đại diện" ng-click="pickAvatar()">
                                        <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 8a4 4 0 100 8 4 4 0 000-8zm7-3h-2.2l-.7-1.4A2 2 0 0014.3 2H9.7a2 2 0 00-1.8 1.1L7.2 5H5a2 2 0 00-2 2v10a3 3 0 003 3h12a3 3 0 003-3V7a2 2 0 00-2-2z" fill="currentColor"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="user-info">
                                    <strong class="name">{{ $customer->fullname }}</strong>
                                    <span class="email">{{ $customer->email }}</span>
                                    <a class="btn btn-ghost btn-logout">Đăng xuất</a>
                                </div>
                            </div>

                            <nav class="account-menu" aria-label="Menu tài khoản">
                                <a class="menu-item  is-active" href="#orders" data-tab="orders">
                                    <span class="mi-icon">🧾</span> Bài viết đã mua
                                </a>
                                <a class="menu-item" href="#info" data-tab="info">
                                    <span class="mi-icon">✎</span> Thay đổi thông tin tài khoản
                                </a>
                                <a class="menu-item btn-logout" href="#">
                                    <span class="mi-icon">↩</span> Đăng xuất
                                </a>
                            </nav>
                        </aside>

                        <!-- MAIN -->
                        <main class="account-main">
                            <!-- Tab: Thông tin -->
                            <div class="panel" id="info" role="tabpanel">
                                <h3 class="panel-title">Thông tin tài khoản</h3>

                                <form action="" method="post" class="form-styled">
                                    @csrf
                                    <div class="form-grid">
                                        <div class="form-group">
                                            <label for="display_name">Họ tên <span class="req">*</span></label>
                                            <input id="display_name" name="display_name" type="text"
                                                   ng-model="form.fullname">
                                            <small class="hint"></small>
                                            <div class="invalid-feedback d-block" ng-if="errors['fullname']"><% errors['fullname'][0] %></div>

                                        </div>
                                        <div class="form-group">
                                            <label for="email">Địa chỉ email <span class="req">*</span></label>
                                            <input id="email" name="email" type="email"
                                                   ng-model="form.email" disabled>
                                        </div>
                                    </div>

                                    <h4 class="panel-subtitle">Thay đổi mật khẩu</h4>
                                    <div class="form-grid">
                                        <div class="form-group col-span-2">
                                            <label for="current_password">Mật khẩu hiện tại (bỏ trống nếu không
                                                đổi)</label>
                                            <input id="current_password" name="current_password" type="password" ng-model="form.current_password"
                                                   autocomplete="current-password">
                                            <div class="invalid-feedback d-block" ng-if="errors['current_password']">
                                                <% errors['current_password'][0] %>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="new_password">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                                            <input id="new_password" name="new_password" type="password" ng-model="form.new_password"
                                                   autocomplete="new-password">
                                            <div class="invalid-feedback d-block" ng-if="errors['new_password']">
                                                <% errors['new_password'][0] %>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirm_password">Xác nhận mật khẩu mới</label>
                                            <input id="confirm_password" name="confirm_password" type="password" ng-model="form.new_password_confirmation"
                                                   autocomplete="new-password">
                                             <div class="invalid-feedback d-block" ng-if="errors['new_password_confirmation']">
                                                <% errors['new_password_confirmation'][0] %>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button class="btn btn-primary"
                                                type="button"
                                                ng-click="submitInfo()"
                                                ng-disabled="loading"
                                                aria-busy="<% loading %>">
                                            <span ng-if="!loading"><i class="fas fa-save me-1"></i> Lưu thay đổi</span>
                                            <span ng-if="loading"><i class="fas fa-spinner fa-spin me-1"></i> Đang lưu…</span>
                                        </button>

                                    </div>
                                </form>
                            </div>

                            <!-- Tab: Đơn hàng -->
                            <div class="panel  is-active" id="orders" role="tabpanel" aria-hidden="true">
                                <h3 class="panel-title">Quản lý bài viết</h3>
                                <!-- Demo table; thay bằng loop đơn hàng của bạn -->
                                <div class="table-wrap">
                                    <table class="table-orders">
                                        <thead>
                                        <tr>
                                            <th>Mã đơn hàng</th>
                                            <th>Bài viết</th>
                                            <th>Ngày mua</th>
                                            <th>Trạng thái</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($orderDetails ?? [] as $item)
                                            <tr>
                                                <td>{{ $item->order->code ?? ''}}</td>
                                                <td>
                                                    <a href="{{ route('front.blogDetail', $item->post->slug ?? '') }}">{{ $item->post->name ?? ''}}</a><br>
                                                    <span> {{ formatCurrency($item->price) }}đ</span>
                                                </td>
                                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $item->status == 1 ? 'Chờ duyệt' : 'Đã kích hoạt' }}</td>
                                            </tr>
                                        @endforeach
                                        @if(empty($orderDetails) || count($orderDetails)===0)
                                            <tr>
                                                <td colspan="5">Chưa có bài viết nào.</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <style>
                                    #orders .orders-pager{
                                        display:flex;
                                        justify-content:center;
                                        margin:16px 0 4px;
                                    }
                                </style>

                                @if(!empty($orderDetails) && method_exists($orderDetails, 'links'))
                                    <div class="orders-pager">
                                        {{ $orderDetails->fragment('orders')->links('site.pagination.paginate2') }}
                                    </div>
                                @endif
                            </div>
                        </main>
                    </div>
                </div>
            </section>

            <style>
                :root {
                    --acc-bg: #fff;
                    --acc-border: #e8edf2;
                    --acc-muted: #6b7280;
                    --acc-primary: #ff6a00; /* bạn đổi theo brand */
                    --acc-ring: rgba(255, 106, 0, .15);
                    --radius: 14px;
                    --shadow: 0 6px 20px rgba(0, 0, 0, .06);
                    --gap: 22px;
                }

                .account-grid {
                    display: grid;
                    grid-template-columns:280px 1fr;
                    gap: var(--gap);
                }

                .account-aside {
                    position: sticky;
                    top: 24px;
                    height: max-content
                }

                .user-card {
                    background: var(--acc-bg);
                    border: 1px solid var(--acc-border);
                    border-radius: var(--radius);
                    padding: 18px;
                    box-shadow: var(--shadow);
                    text-align: center
                }

                .avatar-user {
                    position: relative;
                    width: 104px;
                    height: 104px;
                    margin: 8px auto 12px
                }

                .avatar-user img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 50%;
                    border: 4px solid #f3f6f9
                }

                .avatar-edit {
                    position: absolute;
                    right: -4px;
                    bottom: -4px;
                    border: 0;
                    background: #fff;
                    border-radius: 999px;
                    padding: 8px;
                    box-shadow: var(--shadow);
                    cursor: pointer
                }

                .user-info .name {
                    display: block;
                    margin-bottom: 2px
                }

                .user-info .email {
                    display: block;
                    color: var(--acc-muted);
                    font-size: .92rem;
                    margin-bottom: 10px
                }

                .btn {
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    border-radius: 12px;
                    padding: 10px 14px;
                    border: 1px solid transparent;
                    cursor: pointer;
                    transition: .2s
                }

                .btn-ghost {
                    background: #fff;
                    border-color: var(--acc-border);
                    color: #111
                }

                .btn-ghost:hover {
                    border-color: #cfd7df
                }

                .btn-primary {
                    background: var(--acc-primary);
                    color: #fff
                }

                .btn-primary:hover {
                    filter: brightness(.95)
                }

                .account-menu {
                    margin-top: 14px;
                    background: var(--acc-bg);
                    border: 1px solid var(--acc-border);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    overflow: hidden
                }

                .account-menu .menu-item {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    padding: 12px 16px;
                    color: #111;
                    border-left: 3px solid transparent
                }

                .account-menu .menu-item + .menu-item {
                    border-top: 1px dashed var(--acc-border)
                }

                .account-menu .menu-item:hover {
                    background: #fafbfc
                }

                .account-menu .menu-item.is-active {
                    background: linear-gradient(0deg, rgba(255, 106, 0, .06), rgba(255, 106, 0, .06));
                    border-left-color: var(--acc-primary)
                }

                .mi-icon {
                    width: 20px;
                    display: inline-block;
                    text-align: center;
                    opacity: .8
                }

                .account-main .panel {
                    display: none;
                    background: var(--acc-bg);
                    border: 1px solid var(--acc-border);
                    border-radius: var(--radius);
                    box-shadow: var(--shadow);
                    padding: 18px
                }

                .account-main .panel.is-active {
                    display: block
                }

                .panel-title {
                    margin: 4px 0 14px
                }

                .panel-subtitle {
                    margin: 10px 0 10px;
                    color: #111
                }

                .form-styled input {
                    width: 100%;
                    padding: 10px 12px;
                    border: 1px solid var(--acc-border);
                    border-radius: 12px;
                    outline: none
                }

                .form-styled input:focus {
                    border-color: var(--acc-primary);
                    box-shadow: 0 0 0 4px var(--acc-ring)
                }

                .form-styled label {
                    display: block;
                    margin: 0 0 6px;
                    font-weight: 600
                }

                .form-styled .hint {
                    display: block;
                    margin-top: 6px;
                    color: var(--acc-muted);
                    font-size: .9rem
                }

                .form-styled .req {
                    color: #ef4444
                }

                .form-grid {
                    display: grid;
                    grid-template-columns:1fr 1fr;
                    gap: 14px
                }

                .form-group.col-span-2 {
                    grid-column: 1/-1
                }

                .form-actions {
                    margin-top: 6px
                }

                .table-wrap {
                    overflow: auto
                }

                .table-orders {
                    width: 100%;
                    border-collapse: separate;
                    border-spacing: 0
                }

                .table-orders th, .table-orders td {
                    padding: 12px 10px;
                    border-bottom: 1px solid var(--acc-border);
                    text-align: left
                }

                .table-orders thead th {
                    background: #fafbfc;
                    font-weight: 700
                }

                /* Responsive */
                @media (max-width: 992px) {
                    .account-grid {
                        grid-template-columns:1fr
                    }

                    .account-aside {
                        position: static
                    }
                }

                @media (max-width: 640px) {
                    .form-grid {
                        grid-template-columns:1fr
                    }

                    .account-menu .menu-item {
                        padding: 12px
                    }
                }
            </style>


            <div class="sec-dec"></div>
        </section>
        <!--about end   -->
    </div>
@endsection

@push('scripts')
    <script>
        // Tabs: click menu to show panel
        document.addEventListener('click', function (e) {
            const link = e.target.closest('.account-menu .menu-item[data-tab]');
            if (!link) return;
            e.preventDefault();
            const tab = link.dataset.tab;

            // active menu
            document.querySelectorAll('.account-menu .menu-item').forEach(a => a.classList.toggle('is-active', a === link));
            // active panel
            document.querySelectorAll('.account-main .panel').forEach(p => p.classList.toggle('is-active', p.id === tab));
        });

        // support open by hash
        window.addEventListener('load', () => {
            const hash = location.hash.replace('#', '');
            if (!hash) return;
            const link = document.querySelector(`.account-menu .menu-item[data-tab="${hash}"]`);
            if (link) {
                link.click();
            }
        });
    </script>
    <script>
        app.controller('profilePage', function ($rootScope, $scope, $interval) {
            $scope.form = @json($customer);

            $scope.avatarPreviewUrl = window.USER_AVATAR_URL;
            $scope.form.avatar = null;
            $scope.pickAvatar = function () {
                document.getElementById('avatar-input').click();
            };

            $scope.$watch('form.avatar', function (newFile) {
                if (!newFile) return;

                const isImage = newFile.type ? newFile.type.startsWith('image/') : /\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(newFile.name || '');
                if (!isImage) {
                    alert('Vui lòng chọn tệp hình ảnh');
                    $scope.form.avatar = null;
                    return;
                }
                const MAX = 5 * 1024 * 1024; // 5MB
                if (newFile.size > MAX) {
                    alert('Ảnh vượt quá 5MB, vui lòng chọn ảnh nhỏ hơn.');
                    $scope.form.avatar = null;
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    $scope.$apply(() => {
                        $scope.avatarPreviewUrl = e.target.result; // hiển thị xem trước
                    });
                };
                reader.readAsDataURL(newFile);
            });



            $scope.submitInfo = function () {
                if ($scope.loading) return;

                $scope.loading = true;
                var fd = new FormData();
                fd.append('fullname', $scope.form.fullname);
                fd.append('email',    $scope.form.email);
                fd.append('current_password',    $scope.form.current_password ?? '');
                fd.append('new_password',    $scope.form.new_password ?? '' );
                fd.append('new_password_confirmation',    $scope.form.new_password_confirmation ?? '');

                if ($scope.form.avatar) {
                    fd.append('avatar', $scope.form.avatar);
                }

                $.ajax({
                    type: 'POST',
                    url:  "{{ route('front.updateProfile') }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $scope.errors = [];
                            toastr.success(response.message);
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 1000);
                        } else {
                            $scope.errors = response.errors;
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
        })
    </script>

@endpush
