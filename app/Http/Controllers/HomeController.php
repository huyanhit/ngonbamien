<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\PostCategory;
use App\Models\Producer;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        return view('pages.home', array_merge($this->getDataLayout(),[
            'slider'    => Slider::where(['active'=> 1, 'type' => 1])->orderby('index', 'ASC')->get(),
            'producer'  => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(9)->get(),
            'products'  => Product::where(['active'=> 1, 'status' => 2])->limit(8)->get(),
            'banners'   => Banner::where(['active'=> 1, 'category' => 1])->orderby('index', 'DESC')->limit(2)->get(),
            'product_categories'  => ProductCategory::where(['active' => 1])->with(['subCategories', 'producers'])->orderby('index', 'ASC')->get(),
            'post_categories' => PostCategory::where(['active' => 1])->limit(3)->with(['posts'])->orderby('index', 'ASC')->get()
        ]));
    }
}
