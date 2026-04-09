@props(['val' => null])
<span class="control-label py-2 text-end lh-lg col-sm-3">
    {{$val['title']}}
    @if(isset($val['validate']))
        @if(is_string($val['validate']) && str_contains($val['validate'], 'required'))
            <span class="text-danger">*</span>
        @endif
        @if(is_array($val['validate']) && in_array('required', $val['validate']))
            <span class="text-danger">*</span>
        @endif
    @endif
</span>