<?php
namespace App\Modules\Admin\Controllers;

use App\Modules\Admin\Services\CommentService;
use Dom\Comment;
use Illuminate\Http\Request;

/**
 * NewsController
 *
 * Controller to house all the functionality directly
 * related to the Admin.
 */
class CommentController extends MyController
{
    public $form;
    public $service;
	function __construct(Request $request){
        parent::__construct($request, new CommentService());
        $this->view['resource'] = $this->request->segment(2);
        $this->view['form'] = array(
            'name'    => array('title'=> 'Người comment', 'type' => self::TEXT),
            'phone'   => array('title'=> 'Điện thoại', 'type' => self::TEXT),
            'content' => array('title'=> 'Nội dung', 'type' => self::AREA),
            'rating'  => array('title'=> 'Điểm', 'type' => self::TEXT, 'group' => 'Hình ảnh'),
            'active'  => array('title'=> 'Trang thái', 'type' => self::CHECK, 'column' => 2, 'group' => 'Công bố'),
        );
        $this->view['list'] = array(
            'name' => array(
                'title'=> 'Người comment',
                'width' => 3,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'content' => array(
                'title'=> 'Nội dung',
                'width' => 7,
                'update'=> true,
                'filter' => array(
                    'type' => self::TEXT,
                    'value' => '',
                ),
            ),
            'active' => array(
                'title' => 'Active',
                'width' => 1,
                'update'=> true,
                'data'  => array(null => self::CHOOSE , 0 => 'Không hiển thị', 1 => 'Hiển thị'),
                'views' => array(
                    'type' => self::CHECK,
                ),
                'filter' => array(
                    'type' => 'select',
                    'value' => '',
                ),
            )
        );
	}

    public function reply(Request $request){
        $comment = [
            'product_id' => $request->get('product_id'),
            'post_id'    => $request->get('post_id'),
            'comment_id' => $request->get('comment_id'),
            'name'       => $request->get('name'),
            'phone'      => $request->get('phone'),
            'content'    => $request->get('content'),
            'rating'     => $request->get('rating'),
            'active'     => 1,
        ];

        $res = $this->service->model->create($comment);
        if($res){
            return redirect(route('board.index'))->with('message_insert', 'Trả lời thành công');;
        }

        return redirect(route('board.index'));
    }

    public function report(Request $request){
        $comment = $this->service->model->find($request->get('comment_id'));
        if($comment){
            $comment->report = 1;
            $comment->save();
            return redirect(route('board.index'))->with('message_insert', 'Báo cáo thành công');;
        }

        return redirect(route('board.index'));
    }
}
