@include('admin.posts.Block')

<script>
    class Post extends BaseClass {
        all_categories = @json(\App\Model\Admin\PostCategory::getForSelect());
        all_tags = @json(\App\Model\Admin\Tag::getForSelect());
        statuses = @json(\App\Model\Admin\Post::STATUSES);
        types = @json(\App\Model\Admin\Post::TYPES);
        no_set = [];

        before(form) {
            this.image = {};
            this.status = 0;
            this.type = 1;
            this.tag_ids = [];
        }

        after(form) {

        }

        get image() {
            return this._image;
        }

        set image(value) {
            this._image = new Image(value, this);
        }

        get price() {
            return this._price ? this._price.toLocaleString('en') : '';
        }

        set price(value) {
            value = parseNumberString(value);
            this._price = value;
        }

        get submit_data() {
            let data = {
                cate_id: this.cate_id,
                name: this.name,
                intro: this.intro,
                body: this.body,
                status: this.status,
                type: this.type,
                price: this._price,
                tag_ids: this.tag_ids.map(val => val.id)

            }

            data = jsonToFormData(data);
            let image = this.image.submit_data;
            if (image) data.append('image', image);

            // let data = new FormData();
            //
            // safeAppend(data, 'name', this.name);
            // safeAppend(data, 'cate_id', this.cate_id);
            // safeAppend(data, 'intro', this.intro);
            // safeAppend(data, 'body', this.body);
            // safeAppend(data, 'status', this.status);
            // safeAppend(data, 'type', this.type);
            // safeAppend(data, 'price', this._price);
            // safeAppend(data, 'tag_ids', this.tag_ids.map(val => val.id));
            //
            //
            // let image = this.image.submit_data;
            // if (image) data.append('image', image);

            return data;
        }
    }
</script>
