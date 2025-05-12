<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchOrderRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\OrderProduct;
use Illuminate\Http\RedirectResponse;
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

    public function search(SearchOrderRequest $request){
        if ($request->phone) {
            $orders = Order::where('phone', $request->phone);
            if ($request->id) {
                $orders = Order::where('id', $request->id);
            }

            $orders = $orders->orderBy('order_status_id', 'DESC')->paginate(4);
            foreach ($orders->items() as $item){
                $item->price = $item->products->sum('price');
            };
            return view('order', array_merge($this->getDataLayout(), ['orders'=> $orders]));
        }

        return view('order', array_merge($this->getDataLayout(), []));
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
                'sex'       => $request->sex,
                'name'      => $request->name,
                'phone'     => $request->phone,
                'address'   => $request->address,
                'note'      => $request->note,
                'total'     => $total + $shipping,
                'coupon'    => Session::get('coupon'),
                'discount'  => $discount,
                'ship_price'=> $shipping,
                'order_status_id' => 1
            ]);

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

        return redirect('/thanh-toan/'.$order->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        if($order->order_status_id == 1){
            return view('pages.pay', array_merge($this->getDataLayout(), [
                'order' => $order,
            ]));
        }else{
            return redirect('/tra-cuu-don-hang?phone='.$order->phone.'&id='.$order->id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order): RedirectResponse
    {
        $order->payment = $request->payment;
        if($request->payment == 1){
            $order->order_status_id = 3;
        }else{
            $order->order_status_id = 2;
        }
        $order->save();

        return redirect('/tra-cuu-don-hang?phone='.$order->phone);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
