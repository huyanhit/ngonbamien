@props(['key' => null, 'val' => null])
<div class="row form-group"> 
    @switch($val['type'])
        @case('hidden')
            {{Form::input('hidden', $key, isset($val['value'])?$val['value']:
                (isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)), array())}}
        @break
        @case('has_many')
            <span class="control-label py-2 text-center lh-lg">
                {{$val['title']}}
            </span>
            <div>
                <div class="options_append_{{$key}}">
                    <div class="append">
                        @if(isset($data->$key))
                            @foreach($data->$key as $k => $items)
                                <div class="card border p-2">
                                    @foreach($val['form'] as $skey => $sval)
                                        @include('Admin::Components.sub_inserts', [
                                            'key_dot' => $key.'_insert.'.$k.'.'.$skey,
                                            'key' => $key.'_insert['.$skey.'][]', 'val'=> $sval, 'data'=>$items[$skey]
                                        ])
                                    @endforeach
                                    <div class="text-center my-2"><button class="btn btn-danger pull-right btn-sm" onclick="removeOption(this)" >Xóa</button></div>
                                </div>
                            @endforeach
                        @else
                            <div class="card border p-2">
                                @foreach($val['form'] as $skey => $sval)
                                    @include('Admin::Components.sub_inserts', [
                                        'key_dot' => $key.'_insert.'.$skey.'.0',
                                        'key' => $key.'_insert['.$skey.'][]', 'val'=> $sval, 'data'=>[]
                                    ])
                                @endforeach
                                <div class="text-center my-2">
                                    <button class="btn btn-danger pull-right btn-sm" onclick="removeOption_{{$key}}(this)">Xóa</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex">
                        <div class="mr-2">
                            <span onclick="addHtmlOption_{{$key}}(this)" class="btn btn-info">
                                 Thêm
                            </span>
                        </div>
                    </div>
                </div>
                <script>
                    let optionAppend_{{$key}} = $('.options_append_{{$key}}').find(".append")
                    let html_{{$key}} = optionAppend_{{$key}}.html();
                    function addHtmlOption_{{$key}}(e){
                        optionAppend_{{$key}}.append(html_{{$key}});
                    }
                    function removeOption_{{$key}}(e){
                        $(e).parent().parent().remove();
                    }
                </script>
            </div>
            @break
        @case('text')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                     array('class' => 'form-control text', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('number')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('number', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                     array('class' => 'form-control number', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('date')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                    array('class' => 'datepicker form-control text','placeholder' =>'Chọn ngày'))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('password')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('confirm')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('password', $key, null , array('class' => 'form-control text', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('select')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::select($key, isset($val['data'])?$val['data']:null , isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('class'=>'form-control select'))}}
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
            @case('selects')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{
                    Form::select($key.'[]', $val['data'],
                    isset($data[$key])?json_decode($data[$key]):(isset($val['value'])?json_decode($val['value']):null),
                    array('class'=>'form-control select choices-multiple-remove-button', 'multiple'))
                }}
                @error($key)
                <label class="text-danger">{{ $message }}</label>
                @enderror
            </div>
            @break
        @case('images')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <span class="images">
                    <span class="image_box_{{$key}}"></span>
                </span>
                <span class="inline">
                    {{ Form::file($key.'[]', array('multiple', 'key'=> $key, 'class'=>'form-control upload_images_field')) }}
                </span>
                @error($key)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('image')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <span class="inline image_box_{{$key}}"></span>
                <span class="inline">
                    {{Form::file($key, array('key'=> $key, 'class'=> 'form-control upload_images_field', 'value' => ''))}}
                </span>
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('image_id')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <span class="inline image_box_{{$key}}"></span>
                <span class="inline">
                    {{ Form::file($key, array('key'=> $key, 'class'=>'form-control upload_images_field', 'value'=> '')) }}
                </span>
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('file')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <span class="inline text_box">{{preg_replace('/(.)*(?:\/)/','',isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}</span>
                <span class="inline">
                    {{Form::file($key, array('id'=>'feature', 'class'=>'form-control' , 'value'=> ''))}}
                </span>
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('check')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <div class="form-check form-switch mt-2">
                    {{Form::checkbox($key, 1, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('class'=>'form-check-input'))}}
                </div>
                @error($key)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('area')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::textarea($key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                    array('class'=>'form-control ckeditor_area', 'placeholder'=>($val['placeholder']??($val['title']??''))))}}
                @error($key)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('slug')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <div class="d-flex">
                    <div class="me-3 pt-2 text-muted text-nowrap"> {{$val['prefix']}}/ </div>
                    <div class="w-100 ">
                        {{Form::input('text', $key, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                            array('class' => 'form-control text-muted', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                            @if(isset($val['reference']))
                                <script> 
                                    const ref  = document.querySelector('[name="{{$val['reference']}}"]'); 
                                    const slug = document.querySelector('[name="{{$key}}"]');
                                    if(ref && slug){
                                        ref.addEventListener('change', function (event) {
                                            slug.value = slugify(event.target.value);
                                        })
                                        slug.addEventListener('keyup', function (event) {
                                            slug.value = slugify(event.target.value);
                                        })
                                    }
                                </script>
                            @endif
                    </div>
                </div>
                @error($key)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @break
    @endswitch
</div>
