@extends('Admin::Layouts.admin')
@section('content')
    <form id="insert" method="post" action="{{ route($resource.'.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-lg-7">
                     @php $groups = [] @endphp
                     @foreach($form as $key => $val)
                         @if((isset($val['column']) && $val['column'] == 1) || !isset($val['column']))
                             @php
                                 $keyGroup = $val['group']?? 'Thông tin chung';
                                 $groups[$keyGroup][$key] = $val
                             @endphp
                         @endif
                     @endforeach
                     @foreach($groups as $name => $forms)
                         <div class="card">
                             <div class="card-header fw-bold">
                                 {{$name}}
                             </div>
                             <div class="card-body">
                                 @foreach($forms as $key => $val)
                                     @include('Admin::Components.inserts', ['key' => $key, 'val'=> $val])
                                 @endforeach
                             </div>
                         </div>
                     @endforeach
                </div>
                <div class="col-lg-5">
                    @php $groups = [] @endphp
                    @foreach($form as $key => $val)
                        @if(isset($val['column']) && $val['column'] == 2)
                            @php
                                $keyGroup = $val['group']?? 'Thông tin chung';
                                $groups[$keyGroup][$key] = $val
                            @endphp
                        @endif
                    @endforeach
                    @foreach($groups as $name => $forms)
                        <div class="card">
                            <div class="card-header fw-bold">
                                {{$name}}
                            </div>
                            <div class="card-body">
                                @foreach($forms as $key => $val)
                                    @include('Admin::Components.inserts', ['key' => $key, 'val'=> $val])
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body form-group text-center">
                            <div class="col-12">
                                <input type="submit" id="submit" name="submit" value="Lưu" class="btn btn-success">
                                <input type="submit" id="submit" name="submit_edit" value="Lưu & Chỉnh Sửa Tiếp" class="btn btn-secondary">
                                @if(Request::get('back'))
                                    <a class="btn btn-info" href="{{Request::root()}}/{{urldecode(Request::get('back'))}}"> Quay lại </a>
                                @else
                                    <a class="btn btn-danger prefix_link" href="{{ route($resource.'.index') }}"> Hủy </a>
                                @endif
                                @if(isset($data['id']))
                                    <span class="option-order">
                                            @if(isset($control['next']))
                                            <a class="btn btn-info" href="{{Request::root()}}/{{$control['next']['link']}}/{{$data['id']}}"> {{$control['next']['title']}} <i title="{{$control['next']['title']}}" class="fa fa-chevron-right"></i></a>
                                        @endif
                                        @if(isset($control['prev']))
                                            <a class="btn btn-info" href="{{Request::root()}}/{{$control['prev']['link']}}/{{$data['id']}}"><i title="{{$control['prev']['title']}}" class="fa fa-chevron-left" aria-hidden="true">{{$control['next']['title']}}</i></a>
                                        @endif
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection
