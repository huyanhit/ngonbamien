<?php
namespace App\Services;

use App\Models\OrderProduct;
use App\Models\ProductOption;
use App\Models\SupplierOrder;
use Exception;

class CartService
{
    
    public function getFeeCart($cart){
        $sShip      = 0;
        $sdownPrice = 0;
        $grouped = $cart['items']->groupBy(function ($item) {
            return $item['extra_info']['supplier'];
        });
        foreach($grouped as $items){
            $ship           = 15000;
            $sPriceQuantity = 0; 
            foreach($items as $item){
                $sPriceQuantity += $item['price'] * $item['quantity'];
            }
            $supports = $items[0]['extra_info']['shop']['support'];
            $ships    = $items[0]['extra_info']['shop']['ship']; 
            if($ships){
                $ship = $ships[0]['fee'];
            }
            $sShip   += $ship;
            if(isset($supports)){
                if(count($supports)){
                    $active = false;
                    foreach($supports as $support){
                        switch($support['support_id']){
                            case 1:
                                $active = $sPriceQuantity >= $support['value_1'];
                                $sShip -= $active? $ship: 0;
                                break;
                            case 2:
                                $active      = $sPriceQuantity >= $support['value_2'];
                                $sdownPrice += $active? $support['value_1']: 0;
                                break;
                        }
                    }
                }
            }
        }
        return [
            'shipping' => $sShip,
            'down'     => $sdownPrice
        ];
    }

    public function saveSupplierOrder($order, $cart){
        $grouped = $cart['items']->groupBy(function ($item) {
            return $item['extra_info']['supplier'];
        });
        foreach($grouped as $items){
            $ship           = 15000;
            $sPriceQuantity = 0; 
            $sShip          = 0;
            $sdownPrice     = 0;
            foreach($items as $item){
                $sPriceQuantity += $item['price'] * $item['quantity'];
            }
            $supports = $items[0]['extra_info']['shop']['support'];
            $ships    = $items[0]['extra_info']['shop']['ship']; 
            if($ships){
                $ship = $ships[0]['fee'];
            }
            $sShip   += $ship;
            if(isset($supports)){
                if(count($supports)){
                    $active = false;
                    foreach($supports as $support){
                        switch($support['support_id']){
                            case 1:
                                $active = $sPriceQuantity >= $support['value_1'];
                                $sShip -= $active? $ship: 0;
                                break;
                            case 2:
                                $active      = $sPriceQuantity >= $support['value_2'];
                                $sdownPrice += $active? $support['value_1']: 0;
                                break;
                        }
                    }
                }
            }

            $sOrder = SupplierOrder::create([
                'supplier_id'   => $items[0]['extra_info']['supplier'],
                'code'          => $order->code,
                'name'          => $order->name,
                'phone'         => $order->phone,
                'address'       => $order->address,
                'note'          => $order->note,
                'coupon'        => $order->coupon,
                'discount'      => $order->discount,
                'order_id'      => $order->id,
                'user_id'       => $order->user_id,
                'total'         => $sPriceQuantity,
                'ship_price'    => $sShip ,
                'down_price'    => $sdownPrice,
                'order_status_id' => 1,
                'active'          => 1
            ]);

            foreach ($items as $item){
                $productOption = ProductOption::find($item->options->id);
                if($productOption->stock - $item->quantity >= 0){
                    OrderProduct::create([
                        'order_id'          => $order->id,
                        'supplier_order_id' => $sOrder->id,
                        'product_id'        => $item->id,
                        'price'      => $item->price,
                        'quantity'   => $item->quantity,
                        'options'    => json_encode($item->options),
                    ]);
                  
                    $productOption->stock = $productOption->stock - $item->quantity;
                    $productOption->save();
                }else{
                    throw new Exception('Sản phẩm <span class="text-danger">'.$item->title.
                        '</span> hiện tại chỉ còn <span class="text-danger">'.$productOption->stock.' sản phẩm </span> nên không đủ số lượng.');
                }
            }
        }
    }
}
