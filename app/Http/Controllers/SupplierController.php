<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Filters\SupplierProductFilter;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Theme;
use Illuminate\Http\Request;
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

    public function show(Request $request, $slug){
        $supplier = Supplier::where('slug', $slug)->first();
        if($supplier){
            $theme = Theme::find($supplier->theme);
            $view  = 'stores.default';
            if($theme && View::exists('stores.'.$theme->theme)){
                $view  = 'stores.'.$supplier->theme;
            }

            $product = Product::inRandomOrder()
                ->where(['products.active'=> 1])
                ->where('supplier_id', $supplier->id)
                ->join('product_option', 'product_option.product_id', '=', 'products.id');
            $selects = ['products.*','product_option.title as option_title', 'product_option.id as option_id', 'price', 'discount'];
            
            if($request->get('danh-muc')){
                $request = $request->merge(['product_category' => $slug]);
                $selects = array_merge($selects, ['product_categories.title as categories_title']);
            }

            if($request->get('xuat-xu')){
                $selects = array_merge($selects, ['producers.title as producer_title']);
            }

            if($request->get('loai') && $request->get('loai') == 'mon-da-mua'){
                $selects = array_merge($selects, ['order_products.title as order_product_title']);
            }

            return view($view, array_merge($this->getDataLayout(),[
                'supplier' => $supplier, 
                'products'  => $product->select($selects)->filter(new SupplierProductFilter($request))->paginate(21),
                'discount_products'=> Product::inRandomOrder()->where('products.active', 1)
                    ->select('products.id', 'product_option.title as option_title', 'product_option.id as option_id',
                        'products.title', 'price', 'discount', 'slug', 'images.uri')
                    ->join('product_option', 'product_option.product_id', '=', 'products.id')
                    ->join('images', 'images.id', '=', 'products.image_id')
                    ->where('discount', '>', 0)->where('supplier_id', $supplier->id)->limit(12)->get(),
                ]
            ));

        }else{
            abort('404');
        }
    }
}
