<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\Producer;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        return view('pages.home', array_merge($this->getDataLayout(),[
            'sliders'            => Slider::where(['active'=> 1, 'type' => 1])->orderby('index', 'ASC')->get(),
            'banners'            => Banner::where(['active'=> 1, 'category' => 1])->orderby('index', 'DESC')->limit(2)->get(),
            'producers'          => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(9)->get(),
            'products'           => Product::where(['active'=> 1, 'status' => 2])->limit(12)->get(),
            'product_categories' => ProductCategory::where(['active' => 1])->with(['subCategories', 'producers'])->orderby('index', 'ASC')->get(),
            'posts'              => Post::where(['active'=> 1])->limit(3)->orderby('id', 'DESC')->get(),
            'post_categories'    => PostCategory::where(['active' => 1])->limit(3)->with(['posts'])->orderby('index', 'ASC')->get()
        ]));
    }
}
