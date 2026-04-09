<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Support\Facades\Session;
use Jackiedo\Cart\Cart;

class CheckController extends Controller
{
    protected $cart;
    public function __construct(Cart $cart){
        $this->cart = $cart;
        $this->cart->name('main');
    }

    public function index(){
        $cart = $this->cart->getDetails();
        $discount = 0;
        $couponData = [];
        $coupon = Session::get('coupon');
        if(!empty($coupon)){
            $couponData = $this->processCoupon($coupon, $this->cart->getDetails());
            if($couponData['discount']){
                $discount = $couponData['discount'];
            }
        }
        $cartService = new CartService();
        $fee = $cartService->getFeeCart($cart);
        return view('pages.checkout', array_merge($this->getDataLayout(), [
            'cart'     => $cart,
            'coupon'   => $couponData,
            'shipping' => $fee['shipping'],
            'down'     => $fee['down'],
            'total'    => $cart->total + $fee['shipping'] - $fee['down'] - $discount
        ]));
    }
    
}
