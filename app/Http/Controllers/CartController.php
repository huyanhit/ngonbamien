<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartAddRequest;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Supplier;
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
        $detail = $this->cart->getDetails();
        return response()->json($detail);
    }

    public function show($id):JsonResponse {
        return response()->json($this->cart->getItem($id));
    }

    public function update(Request $request, $id):JsonResponse {
        if($request->quantity){
            $item = $this->cart->getItem($id);
            if($request->quantity <= $item->get('options')['stock']){
                $this->cart->updateItem($id, [
                    'quantity' => $request->quantity,
                ]);
            }
        }

        return response()->json($this->cart->getDetails());
    }

    public function store(CartAddRequest $request):JsonResponse {
        $product = Product::where('active', 1)->find($request->id);
        $shops   = [];
        if(!empty($product)){
            if(isset($request->option_id)) {
                foreach ($product->product_option as $option) {
                    if ($request->option_id == $option->id && $request->quantity <= $option->stock) {
                        if(!isset($shops[$product->supplier_id])){
                            $supplier = Supplier::find($product->supplier_id);
                            if($supplier){
                                $shops[$product->supplier_id] = [
                                    "name"      => $supplier->title,
                                    "image_id"  => $supplier->image_id,
                                    "slug"      => $supplier->slug,
                                    "support"   => $supplier->supplier_support,
                                    "ship"      => $supplier->supplier_ship
                                ];
                            };
                        }
                        $this->cart->addItem([
                            'id'       => $product->id,
                            'title'    => empty($product->title) ? 'No name' : $product->title,
                            'price'    => $option->price - ($option->price * $option->discount /100),
                            'quantity' => $request->quantity,
                            'options'  => $option->toArray(),
                            'extra_info' => [
                                'supplier' => $product->supplier_id,
                                'shop'     => $shops[$product->supplier_id]??[
                                    "name"      => '',
                                    "image_id"  => '',
                                    "support"   => [],
                                    "ship"      => [],
                                ],
                                'link'     => route('san-pham', $product->slug),
                                'image_id' => $product->image_id,
                            ],
                        ]);
                    }
                }
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
