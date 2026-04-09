<?php

namespace App\Modules\Admin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class MyController extends BaseController
{
    const CHOOSE      = 'Chọn';
    const CHECK       = 'check';
    const IMAGE_ID    = 'image_id';
    const IMAGE       = 'image';
    const IMAGES      = 'images';
    const PASSWORD    = 'password';
    const CONFIRM     = 'confirm';
    const SELECT      = 'select';
    const SELECTS     = 'selects';
    
    const AREA        = 'area';
    const CODE        = 'code';
    const TEXT        = 'text';
    const PHONE       = 'phone';
    const PRICE       = 'price';
    const DATE        = 'date';
    const AUTH        = 'auth';
    const HIDDEN      = 'hidden';
    const SLUG        = 'slug';

    const NUMBER      = 'number';
    const HAS_MANY    = 'has_many';
    const HAS_PIVOT   = 'has_pivot';

    public $request;
    public $service;
    public $hookData;
    public $route;
    public $view = [
        'form' => [],
        'list' => [],
        'form_option' => [],
        'list_option' => [
            'hide_action' => []
        ],
    ];
    function __construct($request, $service){
        $this->request          = $request;
        $this->service          = $service;
        $this->hookData         = null;
    }

    public function init(&$result){
        Session::put('page', $this->request->get('page'));
        if(request()->segment(2) != Session::get('router_prefix')){
            Session::forget('page');
            Session::forget('url_sort');
            Session::forget('filter');
            Session::put('router_prefix', request()->segment(2));
        }

        $this->sort($result);
        $this->filter($result);
        $this->paginate($result);
    }

    public function index(){
        $this->init($this->view);
        $this->view['data'] = $this->service->generateList($this->view);
        return view('Admin::list', $this->view);
	}

    public function create(){
        return view('Admin::insert', $this->view);
    }

    public function store(){
        if($this->request->get('process_mutil_record')){
            $process = $this->request->get('process_mutil_record');
            $ids = $this->request->get('ids');
            $this->processMultilRecord($process, $ids);
        }else{
            $id = $this->service->addData($this->request, $this->view);
            if($this->request->get('submit')){
                return redirect(route($this->view['resource'].'.index'));
            }
            if($this->request->get('submit_edit')){
                return redirect(route($this->view['resource'].'.edit', [$id]))->with('message_insert', 'Thêm thành công');
            }
            
            return $id;
        }
    }

    public function show($id){
        $this->view['data'] = $this->service->model->where(['id'=> $id])->first();
        if($this->view['data']){
            return view('Admin::insert', $this->view);
        }

        return redirect('404');
    }

    public function edit($id){
        $this->view['data'] = $this->service->model->where(['id'=> $id])->first();
        if($this->view['data']){
            return view('Admin::edit', $this->view);
        }

        return redirect('404');
    }

    public function update($id){
        if($this->service->editData($this->request, $id, $this->view)){
            if($this->request->get('submit')){
                if($this->request->get('back')){
                    return redirect($this->request('back').Session::get('url_sort'));
                }else{
                    return redirect(route($this->view['resource'].'.index').Session::get('url_sort'));
                }
            }
            if($this->request->get('submit_edit')){
                return redirect(route($this->view['resource'].'.edit', $id))
                    ->with('message_update', 'Cập nhật thành công');
            }
        }else{
            return redirect(route($this->view['resource'].'.edit', $id))
                ->with('message_error', 'Cập nhật thất bại');
        }
    }

    public function destroy($ids){
        return $this->service->deleteData($ids);
    }

    public function getField($field, $id){
        return $this->service->model->select($field)->where(['id'=> $id])->first();
    }

    protected function sort(&$result){
        if($this->request->get('order') && $this->request->get('by')){
            $result['sort']['order'] = $this->request->get('order');
            $result['sort']['by']    = $this->request->get('by');
        }else{
            $result['sort']['order'] = 'id';
            $result['sort']['by']    = 'desc';
            foreach ($result['list'] as $value){
                if(isset($value['sort']['order']) && isset($value['sort']['by'])){
                    $result['sort']['order'] = $value['sort']['order'];
                    $result['sort']['by']    = $value['sort']['by'];
                    break;
                }
            }
        }

        if(isset($result['sort'])){
            if(Session::get('page') != null){
                $result['url_sort'] = '?page=' . Session::get('page') . '&order=' . $result['sort']['order'] . '&by='.  $result['sort']['by'];
            }else{
                $result['url_sort'] = '?order=' . $result['sort']['order'] . '&by='.  $result['sort']['by'];
            }

        }else{
            if(Session::get('page') != null){
                $result['url_sort'] = '?page=' . Session::get('page');
            }else{
                $result['url_sort'] = "";
            }
        }
        Session::put('url_sort', $result['url_sort']);
    }

    protected function filter(&$result){
        $filterData = Session::get('filter');
        if(!empty($filterData)){
            foreach($filterData as $key => $filter){
                if(isset($result['list'][$key])){
                    $result['list'][$key]['filter']['value'] = $filter;
                }
            }
        }

        foreach($result['list'] as $key => $value){
            $data = $this->request->get($key);
            if($this->request->get('submit')){
                $result['list'][$key]['filter']['value'] = $filterData[$key] = $data;
            }
        }
        Session::put('filter', $filterData);
    }

    protected function paginate(&$result, $paginate = null){
        if(!empty($paginate)){
            $result['paginate'] = $paginate;
        }else{
            $result['paginate'] = array('page' => 12);
        }
    }

    protected function renderSelectByTable($data, $key = 'id', $val = 'name', $option = true){
        $render = [];
        if($option) $render[null] = self::CHOOSE;
        if(!empty($data)){
            foreach ($data as $value){
                if(isset($value[$key]) && isset($value[$val])){
                    $render[$value[$key]] = $value[$val];
                }
            }
        }
        return $render;
    }

    protected function getDataTable($table, $where = null, $select = null){
        return $this->service->getDataTable($table, $where, $select);
    }

    private function processMultilRecord($process, $ids){
        switch($process){
            case "deletes":
                return $this->service->deleteData($ids);
            case "actives":
                return $this->service->activeData($ids, true);
            case "un-actives":
                return $this->service->activeData($ids, false);
                
        }
    }
}
