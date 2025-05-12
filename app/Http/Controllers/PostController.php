<?php

namespace App\Http\Controllers;

use App\Filters\PostFilter;
use App\Http\Requests\CartAddRequest;
use App\Models\Counter;
use App\Models\Partner;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\PostRecent;
use App\Models\Producer;
use App\Models\Product;
use App\Models\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request, $slug = null){
        $posts = Post::where(['posts.active'=> 1]);
        $selects = ['posts.*'];
        if($slug){
            $request = $request->merge(['post_category' => $slug]);
            $selects = array_merge($selects, ['post_categories.title as categories_title']);
        }

        return view('pages.blog', array_merge($this->getDataLayout(), [
            'posts'         => $posts->filter(new PostFilter($request))->select($selects)->paginate(6),
            'sliders'       => Slider::where(['active'=> 1, 'type' => 1])->orderby('index', 'DESC')->get(),
            'producers'     => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(9)->get(),
            'post_category' => PostCategory::where(['active' => 1])->limit(9)->get(),
            'post_recent'   => Post::whereIn('id', PostRecent::where('user_id', Auth::id())->pluck('id'))
                ->where(['active' => 1])->limit(4)->get(),
        ]));
    }

    public function show($slug){
        $post = Post::where(['active' => 1,'slug' => $slug])->first();
        if(!empty($post)){
            if(Auth::check()){
                PostRecent::updateOrCreate([
                    'post_id' => $post->id,
                    'user_id' => Auth::id(),
                ],[ 'time' => Carbon::now()]);
            }
            $post->view = $post->view + 1;
            $post->save();
            return view('pages.blog-detail', array_merge($this->getDataLayout(), [
                'post'          => $post,
                'post_category' => PostCategory::where(['active' => 1])->limit(9)->get(),
                'post_recent'   => Post::whereIn('id', PostRecent::where('user_id', Auth::id())->pluck('id'))
                    ->where(['active' => 1])->limit(4)->get(),
                'post_same'     => Post::where(['active' => 1, 'post_category_id' => $post->post_category_id])
                    ->limit(3)->get(),
                'meta' => [
                    'title' => $post->meta_title,
                    'description' => $post->meta_description,
                    'keyword' => $post->meta_keywords
                ]
            ]));
        }

        return view('pages.404', $this->getDataLayout());
    }

    public function productCategory(Request $request){
        $product = Product::select('id', 'title', 'price', 'image_id', 'product_category_id')->find($request->id);
        $query   = Product::select('id', 'title', 'price', 'image_id')
                        ->where('product_category_id', $product->product_category_id)
                        ->where('title', 'like', '%' . $request->search . '%')
                        ->where('id', '!=', $request->id)->limit(20);

        return ['product' => $product, 'list' => $query->get()];
    }
    public function compare($name, $name2 = null){
        $product  = [];
        $product2 = [];
        if(!empty($name)){
            $data = explode('-', $name);
            $id = end($data);
            if(is_numeric($id)){
                $product = Product::where(['active'=> 1,'id' => $id])->first();
            }
        }
        if(!empty($name2)){
            $data2 = explode('-', $name2);
            $id2 = end($data2);
            if(is_numeric($id2)){
                $product2 = Product::where(['active'=> 1,'id' => $id2])->first();
            }
        }
        return view('product-compare', array_merge($this->getDataLayout(), [
            'product' => $product,
            'product2'=> $product2,
            'meta' => [
                'title' => $product->title,
                'description' => $product->keywords .'| Mã '. $product->producer->title.' | Thương hiệu '.$product->sku,
                'keyword' => $product->keywords
            ]
        ]));
    }
    public function search(Request $request){
        $products = Product::where(['active'=> 1])
        -> where('sku', 'like', $request->get('tu_khoa') . '%')
        -> orwhere('keywords', 'like', '%' .  $request->get('tu_khoa') . '%')
        -> orWhere('title', 'like', '%' .  $request->get('tu_khoa') . '%')
        -> orderby('created_at', 'ASC')->paginate(10);

        return view('search', array_merge($this->getDataLayout(), [
            'products' => $products,
        ]));
    }
}
