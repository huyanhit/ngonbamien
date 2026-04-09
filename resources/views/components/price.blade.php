@props(['item' => null])
@php $show = false; $has= false; $count = count($item) - 1; @endphp
@foreach ($item as $key => $price)
    @php 
        if($key == 0){
            $show = $price->stock;
        }
        if($key > 0){
            $show = ($price->stock && !$show);
        }
        if($show){
            $has = true;
        }
    @endphp
    @if($price->stock)
        <div class="product__item__price text-center {{$show? 'show': 'hide'}}" data-value="{{$price->id}}">
            @if(empty($price->price) || ($price->price < $price->price_root))
                <div><b class="text-danger price">Liên hệ</b></div>
                <div class="mx-1 badge badge-light price-title"  title="{{$price->title}}"> {{$price->title}} </div>
            @else
                @if($price->discount)
                    <div>
                        <b class="text-danger price">{{ number_format($price->price - ($price->price * $price->discount /100), 0, ',', '.') }}đ</b>
                        <span class="text-muted price_root">{{ number_format($price->price, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="mx-1 badge badge-light price-title"  title="{{$price->title}}"> {{$price->title}} </div>
                @else
                    <div><b class="text-danger price">{{ number_format($price->price, 0, ',', '.') }}đ</b> </div>
                    <div class="mx-1 badge badge-light price-title" title="{{$price->title}}"> {{$price->title}} </div>
                @endif
            @endif
        </div>
    @else
        <div class="product__item__price text-center {{($count == $key) && !$has? 'show': 'hide'}} ">
            <div class="pt-2"> <b class="text-danger price"> Hết hàng </b></div>
        </div>
    @endif
@endforeach
