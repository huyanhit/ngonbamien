@extends('Admin::Layouts.admin')
@section('content')
<div id="list" class="card">
    <div class="card-body">
        <table class="table table-hover table-bordered align-middle table-nowrap mb-0">
            <thead>
                <tr>
                    <th width="3%" class="text-center">
                        <input type="checkbox" name="checkall" id="checkAll" class="form-check-input">
                        {{ csrf_field() }}
                    </th>
                    @foreach($list as $key => $val)
                        @if(!isset($val['hidden']))
                        <th width="{{isset($val['width'])?$val['width']:''}}%">
                            <div class="d-flex flex-fill">
                                <span class="flex-grow-1">{{isset($val['title'])?$val['title']:''}}</span>
                                @if(!isset($val['sort']) || ($val['sort'] != 'hidden'))
                                    <span class="flex-shrink-1 d-flex" title="Sắp Xếp">
                                        @if(($sort['order'] == $key))
                                            @if($sort['by'] == 'asc')
                                                <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                '?page='.Session::get('page').'&order='.$key.'&by=asc': '?order='.$key.'&by='}}">
                                                    <i class="ri-arrow-up-s-fill" aria-hidden="true"></i>
                                                </a>
                                            @else
                                                <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                    '?page='.Session::get('page').'&order='.$key.'&by=desc': '?order='.$key.'&by=asc'}}">
                                                    <i class="ri-arrow-down-s-fill" aria-hidden="true"></i>
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{Request::url()}}{{(Session::get('page') != null)?
                                                '?page='.Session::get('page').'&order='.$key.'&by=desc': '?order='.$key.'&by=desc'}}">
                                                <i class="ri-expand-up-down-fill" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </th>
                        @endif
                    @endforeach
                    <th width="8%" class="text-center">
                        Thực Hiện
                    </th>
                </tr>
            </thead>
            <form id="filter" method="get" action="{{Request::url().$url_sort}}">
                <tr class="filter-list table-light">
                    <td class="text-center align-middle">
                        #
                    </td>
                    @foreach($list as $key => $val)
                        @if(!isset($val['hidden']))
                            <td>
                            @if(isset($val['filter']['type']))
                                @switch($val['filter']['type'])
                                    @case('text')
                                        {{Form::input('text', $key, $val['filter']['value'], array('class' => 'form-control', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                                    @break
                                    @case('select')
                                        {{Form::select($key, $val['data'], isset($val['filter']['value'])? $val['filter']['value']: null, array('class' => 'form-control'))}}
                                    @break
                                    @default
                                        {{Form::input('text',$key, $val['filter']['value'], array('class' => 'form-control', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                                    @break
                                @endswitch
                            @endif
                            </td>
                        @endif
                    @endforeach
                    <td colspan="2" class="text-center">
                        <div class="group-button">
                            <input type="submit" class="btn btn-secondary" name="submit" value="Lọc">
                            @if(isset($control['add_reference']))
                                <a class="btn btn-insert" href="{{Request::root()}}/{{$control['add_reference']['link']}}"> {{$control['add_reference']['title']}} </a>
                            @endif
                            @if(!isset($control['add']))
                                <a class="btn btn-info btn-insert" href="{{route($resource.'.create')}}"> Thêm </a>
                            @endif
                        </div>
                    </td>
                </tr>
            </form>
            <tbody>
                @foreach($data as $l_key => $l_value)
                <tr>
                    <td class="text-center">
                        <input class="item_id" type="checkbox" name="check" data="{{$l_value['id']}}">
                    </td>
                    @foreach($list as $key => $val)
                        @if(!isset($val['hidden']))
                            @if(isset($val['views']) && isset($val['views']['type']))
                                @switch($val['views']['type'])
                                    @case('images')
                                        <td class="text-center">
                                            @if(!empty($l_value[$key]))
                                                @foreach (explode(',', $l_value[$key]) as $item)
                                                    <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $item)}}"></span>
                                                @endforeach
                                            @endif
                                        </td>
                                    @break
                                    @case('image')
                                        <td class="text-center">
                                        @if(empty($val['update']) )
                                            <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
                                        @else
                                            <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{$l_value[$key]}}"></span>
                                            </span>
                                        @endif
                                        </td>
                                    @break
                                    @case('image_id')
                                        <td class="text-center">
                                        @if(empty($val['update']) && isset($l_value[$key]))
                                            <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
                                        @else
                                            <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                @if($l_value[$key])
                                                <span><img class="avatar-sm my-1 border rounded" onerror="this.src='/images/no-image.png'" src="{{route('get-image-thumbnail', $l_value[$key])}}"></span>
                                                @endif
                                            </span>
                                        @endif
                                        </td>
                                    @break
                                    @case('file')
                                        <td class="text-center">
                                        @if(empty($val['update']) )
                                            <span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
                                        @else
                                            <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                <span>{{preg_replace('/(.)*(?:\/)/','',$l_value[$key])}}</span>
                                            </span>
                                        @endif
                                        </td>
                                    @break
                                    @case('check')
                                        <td class="text-center form-switch check-list">
                                            {{Form::checkbox($key, $l_value['id'], $l_value[$key], array('class'=>'form-check-input', 'fid='.$l_value['id'], (empty($val['update']) )?'disabled':''))}}
                                        </td>
                                    @break
                                    @case('select')
                                        <td class="text-left">
                                        @if(empty($val['update']) )
                                            <span class="no-update">
                                                @foreach($val['data'] as $k => $value)
                                                    @if($l_value[$key] == $k)
                                                        {{$value}}
                                                    @endif
                                                @endforeach
                                            </span>
                                        @else
                                            <span class="can_update_text" type="{{$val['views']['type']}}" data="{{json_encode($val['data'])}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                @foreach($val['data'] as $k => $value)
                                                    @if($l_value[$key] == $k)
                                                        <span class="inline" uid="{{$k}}">{{$value}}</span>
                                                    @endif
                                                @endforeach
                                            </span>
                                        @endif
                                        </td>
                                    @break
                                    @case('area')
                                        <td class="text-left">
                                            @if(empty($val['update']) )
                                                <span class="no-update">{!! $l_value[$key] !!}</span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    <span class="inline">{!! $l_value[$key] !!}</span>
                                                </span>
                                            @endif
                                        </td>
                                    @break
                                    @case('text')
                                        <td class="text-left">
                                            @if(empty($val['update']) )
                                                <span class="p-2">{!! $l_value[$key] !!}</span>
                                            @else
                                                <span class="can_update_text" type="{{$val['views']['type']}}" field="{{$key}}" uid="{{$l_value['id']}}">
                                                    <span class="p-2">{!! $l_value[$key] !!}</span>
                                                </span>
                                            @endif
                                        </td>
                                    @break
                                    @default
                                        <td class="text-left">
                                            <span class="p-2">{!! $l_value[$key] !!}</span>
                                        </td>
                                    @break
                                @endswitch
                            @else
                                <td class="text-left">
                                @if(empty($val['update']) )
                                    <span class="no-update">{!! $l_value[$key] !!}</span>
                                @else
                                    <span class="can_update_text" field="{{$key}}" type="text" uid="{{$l_value['id']}}">
                                        <span class="inline">{!! $l_value[$key] !!}</span>
                                    </span>
                                @endif
                                </td>
                            @endif
                        @endif
                    @endforeach
                    <td class="action_row text-center">
                        <a title="Sao Chép" href="{{route($resource.'.show', $l_value['id'])}}" class="btn btn-secondary btn-sm"><i class="ri ri-file-copy-line" aria-hidden="true"></i></a>
                        <a title="Chỉnh Sửa" href="{{route($resource.'.edit', $l_value['id'])}}" class="btn btn-info btn-sm"><i class="ri ri-pencil-line" aria-hidden="true"></i></a>
                        <a title="Xóa" class="btn btn-danger ajax_delete btn-sm" href="javascript:void(0)" url="{{ route($resource.'.destroy', $l_value['id'])}}"><i class="ri ri-close-line" aria-hidden="true"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-md-6 action mb-2">
            </div>
            <div class="col-md-6">
                @if(!empty($paginate))
                    {!! $data->appends(['order' => Request::get('order'), 'by'=>Request::get('by')])->links('vendor.pagination.bootstrap-4') !!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


