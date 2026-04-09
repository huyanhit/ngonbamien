<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\Product;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(CommentRequest $request){
       
        $data = [
            'product_id'    => $request?->product_id,
            'name'          => $request->name,
            'phone'         => $request->phone,
            'rating'        => $request->rating,
            'content'       => $request->get('content'),
            'active'        => 0
        ];
        
        $comment = Comment::create($data);
        if($comment && $request->ajax()){
            $product = Product::find($request?->product_id);
            NotificationService::pushNotification('comment_product_detail', [
                'product_name' => $product->title,
                'tos'     => User::where('role', 1)->get()->pluck('id'),  
                'id'      => $comment->id,
                'name'    => $request->name,
                'content' => $request->get('content'),
                'phone'   => $request->phone,
            ]);

            return $comment;
        }

        abort('404');
    }

    public function postComment(Request $request){
        $data = [
            'post_id'       => $request?->post_id,
            'name'          => $request->name,
            'content'       => $request->get('content'),
            'active'        => 1
        ];
        $comment = PostComment::create($data);
        if($comment && $request->ajax()){
            $post = Post::find($request?->post_id);
            NotificationService::pushNotification('comment_post_detail', [
                'post_name' => $post->title,
                'tos'       => User::where('role', 1)->get()->pluck('id'),  
                'id'        => $comment->id,
                'name'      => $request->name,
                'content'   => $request->get('content'),
            ]);
            return $comment;
        }

        abort('404');
    }

    public function loadComment(Request $request){
        $productId = $request->product_id;
        $serviceId = $request->service_id;
        if(isset($productId)){
            $comments = Comment::where('product_id', $productId)->where('active', 1)->orderBy('id', 'desc')->paginate(10);
           
        }elseif(isset($serviceId)){
            $comments = Comment::where('service_id', $serviceId)->where('active', 1)->orderBy('id', 'desc')->paginate(10);
        }
        
        if(!empty($comments) && $request->ajax()){
           
            return $comments;
        }

        abort('404');
    }
}
