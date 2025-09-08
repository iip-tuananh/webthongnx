@extends('layouts.main')

@section('css')
@endsection

@section('page_title')
    Chi tiết đơn hàng
@endsection

@section('title')
    Chi tiết đơn hàng
@endsection

@section('buttons')
@endsection

@section('content')

<div ng-controller="Order" ng-cloak>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6>Đơn hàng #<% form.code %></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Mã đơn hàng: <% form.code %> </label>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Khách hàng: <% form.customer.fullname %>  – <% form.customer.code %>
                                    <a ng-if="form.customer_id"
                                       ng-href="/admin/customers/<% form.customer_id %>/show"
                                       class="ms-2 text-primary"
                                       title="Xem chi tiết khách hàng">
                                        <i class="fa fa-user-circle fa-lg"></i>
                                    </a>
                                </label>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email: <% form.customer.email %></label>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Tổng tiền: <% form.total_price | number %></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-control form-control-sm"
                                        ng-model="form.status">
                                    <option  ng-repeat="s in statuses" ng-value="s.id"  ng-selected="form.status == s.id"><% s.name %></option>
                                </select>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Chi tiết</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <table class="table table-bordered table-hover table-responsive">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Giá tiền</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="detail in form.details track by $index">
                                <td class="text-center"><% $index + 1 %></td>
                                <td class="text-center"><% detail.post.name %></td>
                                <td class="text-center" ng-if="detail.price > 0"><% detail.price | number %></td>
                                <td class="text-center" ng-if="detail.price <= 0">Liên hệ</td>
                                <td class="text-center"><% detail.qty | number %></td>
                                <td class="text-right" ng-if="detail.price > 0"><% (detail.qty * detail.price) | number %></td>
                                <td class="text-right" ng-if="detail.price <= 0">Liên hệ</td>
                                <td class="text-center">
                                    <select
                                        class="form-control form-control-sm"
                                        ng-model="detail.status"
                                        ng-init="detail.status = (detail.status !== undefined ? detail.status : 1)"
                                        ng-options="opt.value as opt.label for opt in [
                                            {value:1,label:'Hủy'},
                                            {value:2,label:'Kích hoạt'}
                                        ]">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Tổng thành tiền: </b></td>
                                <td class="text-right"><b><% form.total_price | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Giảm giá: </b><br>
                                    <span ng-if="form.discount_code" class="text-danger">
                                        <i class="fa fa-tag"></i> <% form.discount_code ? 'Voucher: ' + form.discount_code : '' %>
                                    </span>
                                </td>
                                <td class="text-right"><b><% form.discount_value | number %></b></td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-right"><b>Thành tiền sau giảm: </b></td>
                                <td class="text-right"><b><% form.total_price | number %></b></td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <div class="text-right">
        <button type="button" class="btn btn-success btn-cons" ng-click="submit(1)" ng-disabled="loading.submit">
            <i ng-if="!loading.submit" class="fa fa-save"></i>
            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
            Lưu và gửi mail thông báo đơn hàng được duyệt
        </button>
        <button type="button" class="btn btn-success btn-cons" ng-click="submit(0)" ng-disabled="loading.submit">
            <i ng-if="!loading.submit" class="fa fa-save"></i>
            <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
            Lưu
        </button>

        <a href="{{ route('orders.index') }}" class="btn btn-danger btn-cons">
            <i class="fa fa-remove"></i> Quay lại
        </a>
    </div>
</div>
@endsection

@section('script')
    @include('admin.orders.Order')

    <script>
        app.controller('Order', function ($scope, $http) {
            $scope.form = new Order(@json($order), {scope: $scope});
            $scope.statuses = @json(\App\Model\Admin\Order::STATUSES);
            $scope.$applyAsync();

            $scope.getStatus = function (status) {
                let obj = $scope.statuses.find(val => val.id == status);
                return obj.name;
            }
            $scope.loading = {};
            $scope.submit = function (send = 1) {
                $scope.loading.submit = true;
                let data = {
                    order_id: $scope.form.id,
                    order_status: $scope.form.status,
                    details: $scope.form.details,
                    send: send,
                };

                $.ajax({
                    type: 'POST',
                    url: "/admin/orders/update-status",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = "{{ route('orders.index') }}";
                        } else {
                            toastr.warning(response.message);
                            $scope.errors = response.errors;
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading.submit = false;
                        $scope.$applyAsync();
                    }
                });
            }

        });
    </script>
@endsection
