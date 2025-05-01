<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\Partner;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    public function show($slug){
        $producer = Producer::where(['slug' => $slug, 'active' => 1])->first();
        if(!empty($producer)){
            return view('pages.producer', array_merge($this->getDataLayout(), [
                'producer'   => $producer,
                'producers'  => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(9)->get(),
                'sliders'    => Slider::where(['active'=> 1, 'type' => 1])->orderby('index', 'DESC')->get(),
                'products'   => Product::where(['producer_id'=> $producer->id, 'active'=> 1])->orderby('created_at', 'ASC')->paginate(20),
                'product_categories' => ProductCategory::where(['active' => 1])->orderby('index', 'ASC')->get(),
                'meta'       => collect([
                    'title'       => $producer->meta_title,
                    'description' => $producer->meta_description,
                    'keyword'     => $producer->meta_keywords
                ])
            ]));
        }

        redirect('404');
    }
}
