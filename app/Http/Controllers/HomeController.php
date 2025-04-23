<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use App\Models\Partner;
use App\Models\Producer;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Service;
use App\Models\Site;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index(){
        return view('pages.home', array_merge($this->getDataLayout(),[
            'slider'    => Slider::where(['active'=> 1, 'category' => 1])->orderby('index', 'ASC')->get(),
            'producer'  => Producer::where(['active'=> 1])->orderby('index', 'ASC')->limit(10)->get(),
        ]));
    }
}
