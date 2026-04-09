@props(['item' => null, 'price' => null])
<div class="featured__item">
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
            @if(isset($item->image->uri))
            <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}" alt="{{$item->title}}">
            @endif
        </a>
        <ul class="featured__item__pic__hover">
            <li><span title="Yêu thích" class="add_favor"
                data-value="{{$item->id}}"
                option-value="{{$item->option_id}}"><i class="fa fa-heart"></i></span></li>
            <li><span title="Nhắn tin" class="as_message" data-value="{{$item->id}}"><i class="fa fa-comment"></i></span></li>
            <li><span title="Thêm vào giỏ" class="add_cart"
                data-value="{{$item->id}}"
                option-value="{{$item->option_id}}">
                <i class="fa fa-shopping-cart mr-1"></i>Thêm vào giỏ</span>
            </li>
        </ul>
    </div>
    <div class="featured__item__text">
        <h5>{{$item->title?? 'Không tên'}}</h5>
        <p class="text-muted description">{{$item->description}}</p>
        <h6 class="text-danger">
            @if(empty($item->price) || ($item->price < $item->price_root))
                <div><b class="text-danger price">Liên hệ</b></div>
                <div class="mx-1 badge badge-dark price-title"  title="{{$item->title}}"> {{$item->title}} </div>
            @else
                @if($item->discount)
                    <div class="">
                        <b class="text-danger price">{{ number_format($item->price - ($item->price * $item->discount /100), 0, ',', '.') }}đ</b>
                        <span class="text-muted price_root text-decoration-line-through">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                    </div>
                    <div class="mx-1 badge badge-dark price-title"  title="{{$item->option_title}}"> {{$item->option_title}} </div>
                @else
                    <div><b class="text-danger price">{{ number_format($item->price, 0, ',', '.') }}đ</b> </div>
                    <div class="mx-1 badge badge-dark price-title" title="{{$item->option_title}}"> {{$item->option_title}} </div>
                @endif
            @endif
        </h6>
    </div>
</div>
