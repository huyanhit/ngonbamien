<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchOrderRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jackiedo\Cart\Cart;

class OrderController extends Controller
{
    protected $cart;
    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
        $this->cart->name('main');
    }

    public function search(Request $request){
        if (Auth::check()) {
            $orders = Order::where(['user_id' => Auth::id()]);
            if(!empty($request->code)){
                $orders->where('code', $request->code);
            }
            $orders = $orders->orderBy('order_status_id', 'DESC')->paginate(4);
        }else{
            $request->phone = empty($request->phone)? Session::get('OD_PHONE'): $request->phone;
            $request->code  = empty($request->code)? Session::get('OD_CODE'): $request->code;
            $orders = Order::where(['phone' => $request->phone, 'code' => $request->code]);
            $orders = $orders->orderBy('order_status_id', 'DESC')->paginate(4);
        }

        return view('pages.order', array_merge($this->getDataLayout(), ['orders'=> $orders]));
    }

    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $discount = 0;
            $cart = $this->cart->getDetails();
            $coupon = Session::get('coupon')??'';
            if($cart->isEmpty()){
                return view('pages.checkout', array_merge($this->getDataLayout(), []))
                    ->withErrors('Lỗi! Chưa có sản phẩm trong giỏ hàng.');
            }
            if($coupon){
                $couponData = $this->processCoupon($coupon, $this->cart->getDetails());
                if($couponData['discount']){
                    $discount = $couponData['discount'];
                }
            }
            $total = $cart->total - $discount;
            $shipping = ($total <= 185000)? 15000: (($total > 200000)? 0: (200000 - $total));

            $order = Order::create([
                'code'      => $this->randomCode(),
                'name'      => $request->name,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'note'      => $request->note,
                'total'     => $total + $shipping,
                'coupon'    => Session::get('coupon'),
                'discount'  => $discount,
                'user_id'   => Auth::id(),
                'ship_price'=> $shipping,
                'order_status_id' => 1
            ]);

            Session::put('OD_CODE',  $order->code);
            Session::put('OD_PHONE', $order->phone);

            foreach ($cart->items as $item){
                OrderProduct::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                    'options'    => json_encode($item->options),
                ]);
            }
            DB::commit();
            $this->cart->clearItems();
            Session::forget('coupon');
        }catch (\Exception $ex){
            DB::rollBack();
            return view('pages.checkout', array_merge($this->getDataLayout(), []))->withErrors('Lỗi! cập nhật thông tin.');
        }

        return redirect('/thanh-toan/'.$order->code);
    }

    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $order = Order::where(['code'=>$code])->first();
        if($order->order_status_id < 4){
            return view('pages.pay', array_merge($this->getDataLayout(), [
                'order' => $order,
            ]));
        }else{
            return redirect('/don-hang?phone='.$order->phone.'&code='.$order->code);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, $code): RedirectResponse
    {
        $order = Order::where(['code'=>$code])->first();
        $order->payment = $request->payment;
        if($request->payment == 1){
            $order->order_status_id = 3;
        }else{
            $order->order_status_id = 2;
        }

        $order->save();

        if(Auth::check()){
            return redirect('/don-hang?code='.$order->code);
        }else{
            return redirect('/don-hang?phone='.$order->phone.'&code='.$order->code);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    private function randomCode()
    {
        do {
            $code = 'DH'.substr(uniqid('', true), -6);
        } while (Order::where('code', $code)->exists());

        return $code;
    }
}
