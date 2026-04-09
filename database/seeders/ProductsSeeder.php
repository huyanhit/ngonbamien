<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producers  = DB::table('producers')->get()->pluck('id')->toArray();
        $categories = DB::table('product_categories')->get()->pluck('id')->toArray();
        for($i=0; $i<1000; $i++){
            $title = fake()->text(20);
            $id = DB::table('products')->insertGetId([
                "sku" => Str::random(10),
                "title" => $title,
                "slug" => Str::slug($title),
                "description"=>fake()->text(100),
                "content"=>fake()->text(1000),
                "make"=>fake()->text(1000),
                "image_id"=>rand(67,74),
                "images"=>"[67,68,69,70,71,72,73,74]",
                "meta_title"=>$title,
                "meta_keywords"=>$title,
                "meta_description"=>$title,
                "status"=>rand(1,2),
                "active"=>"1",
                "product_category_id"=>$categories[rand(1, count($categories)-1)],
                "producer_id"=>$producers[rand(1, count($producers)-1)],
                "supplier_id"=> rand(1, 5),
                "tags"=>"[1,2,3]",
                "view"=>rand(1,100000),
                "like"=>rand(1,1000),
                "sell"=>rand(1,200),
                "auth_id"=>rand(0,9),
                "created_at"=>(new DateTime())->modify('-'.rand(0,100).' day'),
                "updated_at"=>(new DateTime()),
            ]);

            $money = rand(1,80)*10000;
            DB::table('product_option')->insert([
                "product_id"=>$id,
                "option_price_id"=>rand(1,8),
                "title"=>fake()->text(10),
                "price_root"=>$money,
                "price"=>floor($money*1.2),
                "discount"=>rand(0,3)*10,
                "stock"=>rand(0,7)*5,
                "sell"=>rand(1,1000),
                "date_in"=>(new DateTime())->modify('-'.rand(0,10).' day'),
                "date_ex"=>(new DateTime())->modify('+'.rand(10,100).' day'),
            ]);
            $money2 = rand(1,80)*10000;
            DB::table('product_option')->insert([
                "product_id"=>$id,
                "option_price_id"=>rand(1,8),
                "title"=>fake()->text(10),
                "price_root"=>$money2,
                "price"=>floor($money2*1.3),
                "discount"=>rand(0,3)*10,
                "stock"=>rand(0,7)*5,
                "sell"=>rand(1,100),
                "date_in"=>(new DateTime())->modify('-'.rand(0,10).' day'),
                "date_ex"=>(new DateTime())->modify('+'.rand(10,100).' day'),
            ]);
        }
    }
}
