<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Models\FavorProduct;
use App\Models\PostCategory;
use App\Models\Producer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductRecent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request, $slug = ''){
        $product = Product::where(['products.active'=> 1])->join('product_option', 'product_option.product_id', '=', 'products.id');
        $selects = ['products.*','product_option.title as option_title', 'price', 'discount'];
        if($slug){
            $request = $request->merge(['product_category' => $slug]);
            $selects = array_merge($selects, ['product_categories.title as categories_title']);
        }

        if($request->get('xuat-xu')){
            $selects = array_merge($selects, ['producers.title as producer_title']);
        }

        if($request->get('loai') && $request->get('loai') == 'mon-da-mua'){
            $selects = array_merge($selects, ['order_products.title as order_product_title']);
        }

        return view('pages.shop-grid', array_merge($this->getDataLayout(), [
            'producers' => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(9)->get(),
            'products'  => $product->select($selects)->filter(new ProductFilter($request))->paginate(9),
            'discount_products' => Product::where('products.active', 1)
                ->select('products.id', 'product_option.title as option_title',
                    'products.title', 'price', 'discount', 'slug', 'images.uri')
                ->join('product_option', 'product_option.product_id', '=', 'products.id')
                ->join('images', 'images.id', '=', 'products.image_id')
                ->where('discount', '>', 0)->get(),
            'product_categories' => ProductCategory::where(['active' => 1])->limit(9)->get(),
        ]));
    }
    public function show($slug){
        $product = Product::where(['active' => 1, 'slug' => $slug])->first();
        if(Auth::check()){
            ProductRecent::updateOrCreate([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
            ],[ 'time' => Carbon::now()]);
        }
        $product->view = $product->view + 1;
        $product->save();
        return view('pages.shop-detail', array_merge($this->getDataLayout(), [
            'product'    => $product,
            'r_products' => Product::where(['active' => 1, 'product_category_id' => $product->product_category_id])
                ->whereNotIn('id', [$product->id])->orderby('created_at', 'ASC')->limit(4)->get(),
            'meta'       => [
                'title'  => $product->meta_title,
                'description' => $product->meta_description,
                'keyword'     => $product->meta_keywords
            ]
        ]));
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
            'product'  => $product,
            'product2' => $product2,
            'meta'     => [
                'title'       => $product->meta_title,
                'description' => $product->meta_description,
                'keyword'     => $product->meta_keywords
            ]
        ]));
    }

    public function favor(Request $request){
        $product = Product::find($request->id);
        if(Auth::check() && !empty($product)){
            FavorProduct::updateOrCreate([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
            ],[ 'time' => Carbon::now()]);
        }
        $product->like = $product->like + 1;
        $product->save();

        return [
            'product' => $product,
            'total'   => FavorProduct::where(['user_id' => Auth::id()])->count(),
        ];
    }

    public function favors(){
        return view('pages.favor', array_merge($this->getDataLayout(), [
            'favors' => Product::join('favor_products',function ($join) {
                 $join->on('favor_products.product_id', '=', 'products.id')->where('favor_products.user_id', '=', Auth::id());
            })->where('products.active', 1)->paginate(8),
        ]));
    }
}
