<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Jackiedo\Cart\Cart;

class CartController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->cart->name('main');
    }

    public function page() {
        return view('pages.shop-cart', array_merge($this->getDataLayout(), [
            'coupon'=> $this->processCoupon(Session::get('coupon'), $this->cart->getDetails()),
        ]));
    }

    public function coupon(Request $request){
        if($request->coupon){
            $coupon = Coupon::where(['code'=> $request->coupon, 'active' => 1])->first();
            if(!empty($coupon)){
                Session::put('coupon', $coupon);
                return view('pages.shop-cart', array_merge($this->getDataLayout(), [
                    'coupon'=> $this->processCoupon($coupon, $this->cart->getDetails())
                ]));
            }
        }

        return view('pages.shop-cart', array_merge($this->getDataLayout(), [
             'coupon'=> $this->processCoupon(Session::get('coupon'), $this->cart->getDetails()),
        ]));
    }

    public function index():JsonResponse {
        return response()->json($this->cart->getDetails());
    }

    public function show($id):JsonResponse {
        return response()->json($this->cart->getItem($id));
    }

    public function update(Request $request, $id):JsonResponse {
        if($request->quantity){
            $this->cart->updateItem($id, [
                'quantity' => $request->quantity,
            ]);
        }

        return response()->json($this->cart->getDetails());
    }

    public function store(CartAddRequest $request):JsonResponse {
        $product = Product::where('active', 1)->find($request->id);
        if(!empty($product)){
            if(isset($request->option_id)) {
                foreach ($product->product_option as $option) {
                    if ($request->option_id == $option->id && $request->quantity <= $option->stock) {
                        $this->cart->addItem([
                            'id'       => $product->id,
                            'title'    => empty($product->title) ? 'No name' : $product->title,
                            'price'    => $option->price - ($option->price * $option->discount /100),
                            'quantity' => $request->quantity,
                            'options'  => $option->toArray(),
                            'extra_info' => [
                                'link' => route('san-pham', $product->slug),
                                'image_id' => $product->image_id,
                            ],
                        ]);
                    }
                }
            }else if($request->quantity <= $product->product_option[0]->stock){
                $this->cart->addItem([
                    'id'       => $product->id,
                    'title'    => empty($product->title) ? 'No name' : $product->title,
                    'price'    => $product->product_option[0]->price - ($product->product_option[0]->price * $product->product_option[0]->discount /100),
                    'options'  => $product->product_option[0]->toArray(),
                    'quantity' => $request->quantity,
                    'extra_info' => [
                        'link' => route('san-pham', $product->slug),
                        'image_id' => $product->image_id,
                    ],
                ]);
            }
        }

        return response()->json($this->cart->getDetails());
    }

    public function destroy($id):JsonResponse{
        return response()->json($this->cart->removeItem($id)->getDetails());
    }

    public function clear():JsonResponse{
        return response()->json($this->cart->clearItems());
    }
}
