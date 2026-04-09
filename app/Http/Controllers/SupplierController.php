<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Theme;
use Illuminate\Support\Facades\View;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $suppliers = Supplier::where('active', 1)->paginate();
        $producers = Producer::where(['active'=> 1])->orderby('index', 'ASC')->get();
        $product_categories = ProductCategory::where(['active' => 1])->orderby('index', 'ASC')->get();
        return view('pages.store', array_merge($this->getDataLayout(), [ 
                'suppliers' => $suppliers,
                'producers' => $producers,
                'product_categories' => $product_categories,
            ])
        );
    }

    public function show($slug){
        $supplier = Supplier::where('slug', $slug)->first();
        if($supplier){
            $theme = Theme::find($supplier->theme);
            if($theme && View::exists('stores.'.$theme->theme)){
                return view('stores.'.$supplier->theme, array_merge($this->getDataLayout(),[
                    'supplier' => $supplier,
                    'discount_products'=> Product::inRandomOrder()->where('products.active', 1)
                        ->select('products.id', 'product_option.title as option_title', 'product_option.id as option_id',
                            'products.title', 'price', 'discount', 'slug', 'images.uri')
                        ->join('product_option', 'product_option.product_id', '=', 'products.id')
                        ->join('images', 'images.id', '=', 'products.image_id')
                        ->where('discount', '>', 0)->where('supplier_id', $supplier->id)->limit(12)->get(),
                    ]
                ));
            }

            return view('stores.default', array_merge($this->getDataLayout(),[
                'supplier' => $supplier,
                'discount_products'=> Product::inRandomOrder()->where('products.active', 1)
                    ->select('products.id', 'product_option.title as option_title', 'product_option.id as option_id',
                        'products.title', 'price', 'discount', 'slug', 'images.uri')
                    ->join('product_option', 'product_option.product_id', '=', 'products.id')
                    ->join('images', 'images.id', '=', 'products.image_id')
                    ->where('discount', '>', 0)->where('supplier_id', $supplier->id)->limit(12)->get(),
            ]));
        }else{
            abort('404');
        }
    }
}
