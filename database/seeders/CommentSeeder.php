<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=0; $i<5000; $i++){
            DB::table('comments')->insertGetId([
                "product_id" => rand(1,1000),
                "rating"=>rand(1,5),
                "name"=>fake()->title(),
                "phone"=>'013456789',
                "content"=>fake()->text(100),
                "active"=>1,
                "created_at"=>(new DateTime())->modify('-'.rand(0,100).' day'),
                "updated_at"=>(new DateTime()),
            ]);
        }
    }
}
