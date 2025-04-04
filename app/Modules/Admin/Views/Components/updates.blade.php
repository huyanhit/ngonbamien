@props(['key' => null, 'val' => null])
<div class="row form-group">
    @switch($val['type'])
    @case('hidden')
        {{Form::input('hidden', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array())}}
        @break
    @case('has_many')
        <label class="control-label lh-lg">{{$val['title']}}</label>
        <div>
            <div id="product_option"></div>
            <div class="options_append_{{$key}}">
                <div class="update">
                    @foreach($data->$key as $k => $items)
                        <div class="card border p-2">
                            @foreach($val['form'] as $skey => $sval)
                                @include('Admin::Components.sub_updates', ['name' => $key.'_update['.$k.']['.$skey.']', 'key' => $skey, 'val'=> $sval, 'data'=> $items])
                            @endforeach
                            <div onclick="removeOption(this)" class="text-center my-2"><button class="btn btn-danger pull-right">Xóa</button></div>
                        </div>
                    @endforeach
                </div>
                <div class="append">
                    <div class="card border p-2">
                        @foreach($val['form'] as $skey => $sval)
                            @include('Admin::Components.inserts', ['key' => $key.'_insert['.$skey.'][]', 'val'=> $sval])
                        @endforeach
                        <div onclick="removeOption(this)" class="text-center my-2"><button class="btn btn-danger pull-right">Xóa</button></div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="mr-2">
                        <span onclick="addHtmlOption(this)" class="btn btn-info">
                             Thêm phân loại
                        </span>
                    </div>
                </div>
            </div>
            <script>
                let optionAppend = $('.options_append_{{$key}}').find(".append")
                let html = optionAppend.html();
                optionAppend.find(".card").remove();
                function addHtmlOption(e){
                    optionAppend.prepend(html);
                }
                function removeOption(e){
                    $(e).parent().remove();
                }
            </script>
        </div>
        @break
    @case('text')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('number')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                array('class' => 'form-control number', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('date')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                array('id' => 'datepicker','class' => 'form-control text','data-date-format'=> "dd/mm/yyyy", 'placeholder' =>'dd/mm/yyyy'))}}
            <script type="text/javascript">
                $('#datepicker').datepicker({weekStart: 1,daysOfWeekHighlighted: "6,0", autoclose: true,todayHighlight: true,});
                $('#datepicker').datepicker("setDate", new Date());
            </script>
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('password')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('confirm')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('select')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            @if(isset($val['ajax']))
                @switch($val['ajax']['type'])
                    @case ('select')
                        {{Form::select($key, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                        array('class'=>'form-control select render_select', 'table'=>$val['ajax']['table'], 'reference'=>$val['ajax']['reference']))}}
                        @break
                @endswitch
            @else
                {{
                    Form::select($key, $val['data'],
                    isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                    array('class'=>'form-control select'))
                }}
            @endif
            @error($key)
            <label class="alert alert-danger">{{ $message }}</label>
            @enderror
        </div>
        @break
    @case('area')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            @include('ckfinder::setup')
            {{Form::textarea($key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
            array('id'=>$key.'area', 'class'=>'form-control', 'placeholder'=>isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($key)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        <script>
            CKEDITOR.replace( '{{$key.'area'}}', {filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}'});
        </script>
        @include('ckfinder::setup')
        @break
    @case('images')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            <span class="images mt-3">
                <span class="image_box_{{$key}}">
                    @if(!empty($data[$key]))
                        @foreach(explode(',', $data[$key]) as $item)
                            @if($item)
                                <span class="images-group images-delete"
                                    url="{{ route($resource.'.update', $data['id']) }}" fid="{{$item}}">
                                    <img class="avatar-lg my-1 border rounded"
                                        onerror="this.src='/images/no-image.png'"
                                        src="{{route('get-image-thumbnail', $item)}}">
                                        <span><i class="fa fa-close" aria-hidden="true"></i></span>
                                </span>
                            @endif
                        @endforeach
                    @endif
                </span>
            </span>
            <span class="inline">
                {{ Form::file($key.'[]', array('multiple', 'key'=> $key, 'class'=>'form-control upload_images_field')) }}
            </span>
            @error($key)
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('image')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            <span class="inline image_box_{{$key}}">
                <img class="avatar-lg border my-2"
                     src="{{route('get-image-resource', $data[$key])}}"
                     onerror="this.src='/images/no-image.png'"></span>
            <span class="inline">
                {{
                    Form::file($key, array('key'=> $key, 'class'=>'form-control upload_images_field',
                    'value' => isset($data[$key])? $data[$key]: (isset($val['value'])? $val['value']: null)))
                }}
            </span>
            @error($key)
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('image_id')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
                <span class="inline image_box_{{$key}}">
                    @if(isset($data[$key]))
                        <img class="avatar-lg border my-2" onerror="this.src='/images/no-image.png'"
                             src="{{route('get-image-thumbnail', $data[$key])}}">
                    @endif
                </span>
                <span class="inline">
                    {{
                        Form::file($key, array('key'=> $key, 'class'=>'form-control upload_images_field',
                        'value'=> isset($data[$key])? route('get-image-thumbnail', $data[$key]):
                        (isset($val['value'])? route('get-image-thumbnail', $val['value']): null)))
                    }}
                </span>
            @error($key)
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('file')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            <span class="inline text_box">{{preg_replace('/(.)*(?:\/)/','',isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}</span>
            <span class="inline">
                {{
                    Form::file($key,  array(
                        'id'=>'feature',
                        'class'=>'form-control',
                        'value'=>isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))
                    )
                }}
            </span>
            @error($key)
                <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('check')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            <div class="form-check form-switch mt-2">
                {{Form::input('hidden', $key, 0)}}
                {{
                    Form::checkbox($key, 1, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                    array('class'=>'form-check-input'))
                }}
                </span>
                @error($key)
                    <span class="alert alert-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        @break
@endswitch
</div>