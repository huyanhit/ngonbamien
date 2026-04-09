@props(['key_dot' => null, 'key' => null, 'val' => null, 'data' => null])
<div class="row form-group">
    @switch($val['type'])
        @case('text')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('text', $key, $data? $data: (isset($val['value'])? $val['value']: null),
                     array('class' => 'form-control', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                @error($key_dot)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('date')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::input('text', $key, $data? $data: (isset($val['value'])? $val['value']: null),
                    array('class' => 'datepicker form-control', 'placeholder' =>'Chọn ngày'))}}
                @error($key_dot)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('number')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <div class="d-flex">
                    {{Form::input('number', $key, $data? $data: (isset($val['value'])? $val['value']: null),
                        array('class' => 'form-control number w-50', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                    <div class="w-50 review p-2 text-danger fs-16">
                        {{ $val['placeholder']??($val['title']??'') }}
                    </div>
                </div>
                @error($key_dot)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
        @case('price')
        @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                <script> 
                    function reviewValue(e){
                        const parent = e.parentElement.parentElement; 
                        parent.querySelector('.review').innerText =
                            new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format( e.value)
                    } 
                </script>
                <div class="d-flex">
                    {{Form::input('number', $key, $data? $data: (isset($val['value'])? $val['value']: null),
                        array('class' => 'form-control number w-50', 'onkeyup'=>'reviewValue(this)', 'placeholder' => ($val['placeholder']??($val['title']??''))))}}
                    <div class="w-50 review p-2 text-danger fs-16 fw-bold">
                        {!! number_format($data? $data: (isset($val['value'])? $val['value']: 0), 0, ',', '.') !!} ₫
                    </div>
                </div>
                @error($key_dot)
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        @break
        @case('select')
            @include('Admin::Components.form_title', ['val' => $val])
            <div class="col-sm-9 my-1">
                {{Form::select($key, isset($val['data'])?$val['data']:null , $data? $data: (isset($val['value'])? $val['value']: null), array('class'=>'form-control select'))}}
                @error($key_dot)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @break
            @case('area')
                @include('Admin::Components.form_title', ['val' => $val])
                <div class="col-sm-9 my-1">
                    {{Form::textarea($key, $data? $data: (isset($val['value'])? $val['value']: null),
                        array('class'=>'form-control ckeditor_area', 'placeholder'=>($val['placeholder']??($val['title']??''))))}}
                    @error($key_dot)
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            @break
    @endswitch
</div>