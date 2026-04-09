<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Producer;
use App\Models\ProductCategory;
use App\Models\Slider;
use App\Models\Product;
use App\Models\RegisterEmail;
use App\Models\Supplier;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('pages.home', array_merge($this->getDataLayout(),[
            'suppliers'          => Supplier::inRandomOrder()->limit(10)->get(),
            'sliders'            => Slider::where(['active'=> 1, 'type' => 1])->orderby('index', 'ASC')->get(),
            'banners'            => Banner::where(['active'=> 1, 'category' => 1])->orderby('index', 'DESC')->limit(2)->get(),
            'producers'          => Producer::where(['active'=> 1])->orderby('index', 'ASC')->get(),
            'products'           => Product::inRandomOrder()->where(['active'=> 1, 'status' => 2])
                                    ->with(['product_option', 'supplier'])->limit(24)->get(),
            'product_categories' => ProductCategory::where(['active' => 1])->with(['subCategories', 'producers'])->orderby('index', 'ASC')->get(),
        ]));
    }

    public function subscribe(Request $request){
        $data =  RegisterEmail::create([
            'email'  => $request->email,
            'active' => 1
        ]);

        if($data && $request->ajax()){
            return $data;
        }

        abort('404');
    }
}
