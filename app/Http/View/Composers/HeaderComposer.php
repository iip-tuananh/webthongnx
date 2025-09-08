<?php

namespace App\Http\View\Composers;

use App\Model\Admin\Category;
use App\Model\Admin\Config;
use App\Model\Admin\Post;
use App\Model\Admin\PostCategory;
use App\Model\Admin\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * Compose Settings Menu
     * @param View $view
     */
    public function compose(View $view)
    {
        $config = Config::query()->get()->first();
        $cartItems = \Cart::session('cartList')->getContent();
        $totalPriceCart = \Cart::session('cartList')->getTotal();

        // danh mục blog
        $postsCategory = PostCategory::query()->with('childs')
            ->where('parent_id', 0)->orderBy('sort_order')->get();
        $posts = Post::query()->where('status', 1)->latest()->get()->take(5);

        $view->with(['config' => $config, 'cartItems' => $cartItems,
            'totalPriceCart' => $totalPriceCart,
           'postsCategory' => $postsCategory,
           'posts' => $posts,
        ]);
    }
}
