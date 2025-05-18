<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Page;
use App\Models\Contact;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;

class PageController extends Controller
{
    public function show($router){
        $view  = 'pages.page';
        $pages = Page::where(['active' => 1,'router'=>$router])->first();
        if(!empty($pages)){
            if(View::exists($router)){
                $view = $router;
            }
            return view($view, array_merge($this->getDataLayout(),[
                'pages' => $pages,
                'product_categories' => ProductCategory::where(['active' => 1])->limit(9)->get(),
                'meta' => collect([
                    'title' => $pages?->title,
                    'description' => $pages?->meta,
                    'keyword' =>  $pages?->meta,
                ])
            ]));
        }else{
            abort('404');
        }
    }

    public function saveContact(ContactRequest $request){
        $isEmail = strpos('@', $request->contact);
        $data = [
            'name'  => $request->name,
            'email' => $isEmail? $request->contact: '',
            'phone' => $isEmail? '': $request->contact,
            'content' => $request->get('content')
        ];
        if(Contact::insertGetId($data)){
            if($request->ajax()){
                return true;
            }else{
                return redirect('/lien-he')->with('success', 'Gửi thành công, Chúng tôi sẻ liên hệ lại sớm.');
            }
        }

        abort('404');
    }

    public function contact(){
        return view('pages.contact', array_merge($this->getDataLayout(), []));
    }
}
