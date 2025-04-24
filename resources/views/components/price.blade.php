@props(['item' => null, 'percent' => true, 'title' => true])
<div class="text-center ml-1">
    <h6 class="text-danger font-weight-bold">{{ number_format($item->price, 0, ',', '.') }}đ
        @if($title)
            <span class="mx-1 badge badge-light " style="font-size: 12px" title="{{$item->title}}"> {{$item->title}} </span>
        @endif
    </h6>
    @if($percent && $item->price_discount)
        <div class="d-flex">
            <del class="text-gray-600 font-weight-bold">{{ number_format($item->price, 0, ',', '.') }}đ </del>
            <span class="bg-red-500 px-2 rounded-2 text-white text-sm"> {{ number_format(($item->price/$item->discount)*100, 0, ',', '.') }} </span>
        </div>
    @endif
</div>
