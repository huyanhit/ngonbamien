<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateOrderStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrs = [
            ['id'=>'1','title' => 'Chưa thanh toán', 'Icon' => 'fa fa-credit-card', 'image_id'=>1, 'index'=> 1, 'active'=> 1],
            ['id'=>'2','title' => 'Chờ xác nhận thanh toán', 'Icon' => 'fa fa-hourglass-half', 'image_id'=>1, 'index'=> 2, 'active'=> 1],
            ['id'=>'3','title' => 'Chờ xác nhận (COD)', 'Icon' => 'fa fa-id-card', 'image_id'=>1, 'index'=> 3, 'active'=> 1],
            ['id'=>'4','title' => 'Đang đóng gói', 'Icon' => 'fa fa-cube', 'image_id'=>1, 'index'=> 4, 'active'=> 1],
            ['id'=>'5','title' => 'Đang giao hàng', 'Icon' => 'fa fa-truck', 'image_id'=>1, 'index'=> 5, 'active'=> 1],
            ['id'=>'6','title' => 'Hoàn thành', 'Icon' => 'fa fa-check-circle', 'image_id'=>1, 'index'=> 6, 'active'=> 1],
            ['id'=>'7','title' => 'Trả hàng', 'Icon' => 'fa fa-return', 'image_id'=>1, 'index'=> 7, 'active'=> 1],
            ['id'=>'8','title' => 'Hủy đơn', 'Icon' => 'fa fa-cancel', 'image_id'=>1, 'index'=> 8, 'active'=> 1],
        ];
        foreach($arrs as $arr){
            DB::table('order_statuses')->insert($arr);
        }
    }
}
