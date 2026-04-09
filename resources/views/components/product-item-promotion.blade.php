@props(['item' => null])

<div class="product__discount__item">
    <div class="featured__item__pic">
        @if($item->supplier)
        <div class="w-100 position-absolute">
            <span class="pull-left p-1 text-left" style="width: 40%">
                <span class="badge badge-dark text-white">{{$item->supplier->title}}</span>
            </span>
            <span class="pull-right text-right p-1" style="width: 60%">
                @if($item->supplier->supplier_support)
                @php $supplier_support = $item->supplier->supplier_support @endphp
                    @foreach ($supplier_support as $sp)
                        @switch($sp->support_id)
                            @case(1)
                                <span class="badge badge-label bg-info text-white small" title="Miễn phí ship đơn từ {{$sp->value_1/1000}}k">Freeship</span>
                                @break
                            @case(2)
                                <span class="badge badge-label bg-success text-white small"  
                                    title="Giảm {{$sp->value_1/1000}}k cho đơn từ {{$sp->value_2/1000}}k" >Giam {{$sp->value_1/1000}}k</span>
                                @break
                            @default
                        @endswitch
                    @endforeach
                @endif
            </span>
        </div>
        @endif
        <a href="{{Request::root()}}/san-pham/{{$item->slug}}">
            @if(isset($item->uri))
                <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->uri)}}" alt="{{$item->title}}">
            @endif
        </a>
        <div class="product__discount__percent">-{{$item->discount}}%</div>
        <ul class="product__item__pic__hover">
            <li><span title="Yêu thích" class="add_favor"
                data-value="{{$item->id}}"
                option-value="{{$item->option_id}}">
                <i class="fa fa-heart"></i></span></li>
            <li><span title="Nhắn tin"><i class="fa fa-comment"></i></span></li>
            <li>
                <span title="Thêm vào giỏ" class="add_cart"
                    data-value="{{$item->id}}"
                    option-value="{{$item->option_id}}">
                    <i class="fa fa-shopping-cart"></i></span>
            </li>
        </ul>
    </div>
    <div class="product__discount__item__text">
        <h5>
            <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
                <b>{{$item->title?? 'Không tên'}}</b>
                @if(!empty($item->option_title))
                    <span class="ml-1 text-muted text-sm" >({{ $item->option_title }})</span>
                @endif
            </a>
        </h5>
        <div class="product__item__price text-danger">
            @if(empty($item->price) || ($item->price < $item->price_root))
                <h5 class="text-danger font-bold">Liên hệ</h5>
            @else
                @if($item->discount)
                    {{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ
                    <span class="text-muted"> {{ number_format($item->price, 0, ',', '.') }}đ</span>
                @else
                    {{ number_format($item->price, 0, ',', '.') }}đ
                @endif
            @endif
        </div>
    </div>
</div>
