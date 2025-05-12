<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $products = [];
        $posts = [];

        if($request->loai == 2 || $request->loai == 1) {
            $products = Product::where(['active' => 1])
                ->where('sku', 'like', $request->get('tu-khoa') . '%')
                ->orWhere('title', 'like', $request->get('tu-khoa') . '%')
                ->orwhere('meta_keywords', 'like', '%' . $request->get('tu-khoa') . '%')
                ->orderby('created_at', 'ASC')->paginate(8);
        }
        if($request->loai == 3 || $request->loai == 1){
            $posts = Post::where(['active'=> 1])
                -> orWhere('title', 'like', $request->get('tu-khoa') . '%')
                -> orwhere('meta_keywords', 'like', '%' .  $request->get('tu-khoa') . '%')
                -> orderby('created_at', 'ASC')->paginate(6);
        }

        return view('pages.search', array_merge($this->getDataLayout(), [
            'products' => $products,
            'posts' => $posts,
        ]));
    }
}
