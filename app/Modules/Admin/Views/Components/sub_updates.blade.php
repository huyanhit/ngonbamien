@props(['name' => null, 'key' => null, 'val' => null, 'data' => null])
<div class="row form-group">
    @switch($val['type'])
    @case('select')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            @if(isset($val['ajax']))
                @switch($val['ajax']['type'])
                    @case ('select')
                        {{Form::select($name, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                        array('class'=>'form-control select render_select', 'table'=>$val['ajax']['table'], 'reference'=>$val['ajax']['reference']))}}
                        @break
                @endswitch
            @else
                {{Form::select($name, $val['data'], isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null), array('class'=>'form-control select'))}}
            @endif
            @error($name)
            <label class="alert alert-danger">{{ $message }}</label>
            @enderror
        </div>
        @break
    @case('text')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('text', $name, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                array('class' => 'form-control text', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($name)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('number')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            {{Form::input('text', $name, isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null),
                array('class' => 'form-control number', 'placeholder' => isset($val['placeholder'])?$val['placeholder']:'Input '.$key))}}
            @error($name)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
    @case('file')
        <label class="control-label py-2 text-end lh-lg col-sm-3">{{$val['title']}}</label>
        <div class="col-sm-9 my-1">
            <span class="inline text_box">{{preg_replace('/(.)*(?:\/)/','',isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null))}}</span>
            <span class="inline">
                {{Form::file($name, array('id'=>'feature', 'class'=>'form-control' , 'value'=>isset($data[$key])?$data[$key]:(isset($val['value'])?$val['value']:null)))}}
            </span>
            @error($name)
            <span class="alert alert-danger">{{ $message }}</span>
            @enderror
        </div>
        @break
@endswitch
</div>