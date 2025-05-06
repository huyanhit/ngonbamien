@props(['item' => null])
@foreach ($item as $key => $price)
    <div class="product__item__price text-center {{$key>0? 'hide': ''}}">
        @if($price->discount)
            <div c>
                <b class="text-danger price">{{ number_format($price->price - ($price->price * $price->discount /100), 0, ',', '.') }}đ</b>
                <span class="text-muted price_root">{{ number_format($price->price, 0, ',', '.') }}đ</span>
            </div>
            <div class="mx-1 badge badge-light price-title"  title="{{$price->title}}"> {{$price->title}} </div>
        @else
            <div> <b class="text-danger price">{{ number_format($price->price, 0, ',', '.') }}đ</b> </div>
            <div class="mx-1 badge badge-light price-title" title="{{$price->title}}"> {{$price->title}} </div>
        @endif
    </div>
@endforeach
