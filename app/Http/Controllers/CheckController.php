<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
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
        $total = $cart->total - $discount;
        $shipping = ($total <= 185000)? 15000: (($total > 200000)? 0: (200000 - $total));
        return view('pages.checkout', array_merge($this->getDataLayout(), [
            'cart' => $cart,
            'coupon' => $couponData,
            'shipping' => $shipping
        ]));
    }
}
