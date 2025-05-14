@props(['item' => null, 'price' => null])
<div class="featured__item">
    <div class="featured__item__pic">
        <a href="{{Request::root()}}/san-pham/{{$item->slug}}">
            <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}" alt="{{$item->title}}">
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
