<style>
    .gallery-item {
        padding: 5px;
        padding-bottom: 0;
        border-radius: 2px;
        border: 1px solid #bbb;
        min-height: 100px;
        height: 100%;
        position: relative;
    }

    .gallery-item .remove {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .gallery-item .drag-handle {
        position: absolute;
        top: 5px;
        left: 5px;
        cursor: move;
    }

    .gallery-item:hover {
        background-color: #eee;
    }

    .gallery-item .image-chooser img {
        max-height: 150px;
    }

    .gallery-item .image-chooser:hover {
        border: 1px dashed green;
    }

    .gallery-area {
    }
</style>
<div class="row">
	<div class="col-md-8 col-sm-8 col-xs-12">

        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Danh mục</label>

            <ui-select remove-selected="true" ng-model="form.cate_id" theme="select2">
                <ui-select-match placeholder="Chọn danh mục">
                    <% $select.selected.name %>
                    <small class="text-muted ms-1" ng-if="$select.selected._label_suffix">
                        <% $select.selected._label_suffix %>
                    </small>
                </ui-select-match>

                <!-- Hiển thị tất cả, nhưng khoá các cha có con -->
                <ui-select-choices
                    repeat="t.id as t in (form.all_categories_marked | filter:$select.search) track by t.id"
                    ui-disable-choice="t._disabled">
                    <div class="d-flex align-items-center">
                        <span ng-bind="t.name"></span>
                        <small class="text-muted ms-2" ng-if="t._label_suffix"><% t._label_suffix %></small>
                    </div>
                </ui-select-choices>
            </ui-select>

            <span class="invalid-feedback d-block" role="alert">
  <strong><% errors.cate_id[0] %></strong>
</span>


        </div>




        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Tiêu đề bài viết</label>
            <input class="form-control" ng-model="form.name" type="text">
            <span class="invalid-feedback d-block" role="alert">
				<strong><% errors.name[0] %></strong>
			</span>
        </div>
        <div class="form-group">
            <label>Mô tả ngắn</label>
            <textarea name="form.intro"  class="form-control"
                     ng-model="form.intro" rows="5"></textarea>

        </div>
        <div class="form-group">
            <label>Nội dung</label>
            <textarea name="form.body"  class="form-control"
                      ck-editor ng-model="form.body" rows="7"></textarea>

        </div>

	</div>

	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="form-group custom-group mb-4">
			<label class="form-label required-label">Trạng thái</label>
			<select id="my-select" class="form-control custom-select" ng-model="form.status">
				<option value="">Chọn trạng thái</option>
				<option ng-repeat="s in form.statuses" ng-value="s.id" ng-selected="form.status == s.id"><% s.name %></option>
			</select>
		</div>

        <div class="form-group custom-group mb-4">
            <label class="form-label required-label">Loại bài viết</label>
            <select id="my-select" class="form-control custom-select" ng-model="form.type">
                <option value="">Chọn loại</option>
                <option ng-repeat="t in form.types" ng-value="t.id" ng-selected="form.type == t.id"><% t.name %></option>
            </select>
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.type[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4" ng-if="form.type == 2">
            <label class="form-label required-label">Giá bán</label>
            <input class="form-control " type="text" ng-model="form.price">
            <span class="invalid-feedback d-block" role="alert">
                <strong>
                    <% errors.price[0] %>
                </strong>
            </span>
        </div>

        <div class="form-group custom-group mb-4">
            <label class="form-label d-flex align-items-center justify-content-between">
                <span>Thẻ tag</span>
            </label>

            <ui-select multiple
                       ng-model="form.tag_ids"
                       theme="select2"
                       close-on-select="false"
                       remove-selected="true"
                       reset-search-input="true"
                       title="Chọn một hoặc nhiều thẻ">
                <ui-select-match placeholder="Chọn thẻ tag...">
      <span class="cate-chip">
       <% $item.name %>
      </span>
                </ui-select-match>

                <ui-select-choices
                    repeat="t as t in (form.all_tags | filter: $select.search) track by t.id"
                >
                    <div class="d-flex align-items-center">
                        <span ng-bind="t.name"></span>
                    </div>
                </ui-select-choices>
            </ui-select>

            <div class="mt-2 d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary"
                        ng-click="form.tag_ids=[]"
                        ng-disabled="!form.tag_ids.length">
                    Xoá hết
                </button>
            </div>

            <span class="invalid-feedback d-block" role="alert" ng-if="errors.tag_ids && errors.tag_ids[0]">
    <strong><% errors.tag_ids[0] %></strong>
  </span>
        </div>

        <div class="card mb-4">
            <div class="card-header text-center ">
                <h5>Ảnh đại diện</h5>
            </div>
            <div class="card-body">
                <div class="form-group text-center mb-4">
                    <div class="main-img-preview">
                        <p class="help-block-img">* Ảnh định dạng: jpg, png không quá 10MB.</p>
                        <img class="thumbnail img-preview" ng-src="<% form.image.path %>">
                    </div>
                    <div class="input-group" style="width: 100%; text-align: center">
                        <div class="input-group-btn" style="margin: 0 auto">
                            <div class="fileUpload fake-shadow cursor-pointer">
                                <label class="mb-0" for="<% form.image.element_id %>">
                                    <i class="glyphicon glyphicon-upload"></i> Chọn ảnh
                                </label>
                                <input class="d-none" id="<% form.image.element_id %>" type="file" class="attachment_upload" accept=".jpg,.jpeg,.png">
                            </div>
                        </div>
                    </div>
                    <span class="invalid-feedback d-block" role="alert">
				<strong><% errors.image[0] %></strong>
			</span>
                </div>
            </div>
        </div>

	</div>
</div>

<hr>
<div class="text-right">
	<button type="submit" class="btn btn-success btn-cons" ng-click="submit(0)" ng-disabled="loading.submit">
		<i ng-if="!loading.submit" class="fa fa-save"></i>
		<i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
		Lưu
	</button>
	<a href="{{ route('Post.index') }}" class="btn btn-danger btn-cons">
		<i class="fa fa-remove"></i> Hủy
	</a>
</div>
