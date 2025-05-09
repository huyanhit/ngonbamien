@props(['item' => null, 'price' => null])
<div class="featured__item">
    <div class="featured__item__pic">
        <a href="{{Request::root()}}/san-pham/{{$item->slug}}">
            <img src="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}" alt="{{$item->title}}">
        </a>
        <ul class="featured__item__pic__hover">
            <li><span title="Yêu thích" class="add_favor" data-value="{{$item->id}}"><i class="fa fa-heart"></i></span></li>
            <li><span title="Nhắn tin" class="as_message" data-value="{{$item->id}}"><i class="fa fa-comment"></i></span></li>
            <li><span title="Thêm vào giỏ" class="add_cart" data-value="{{$item->id}}"><i class="fa fa-shopping-cart"></i></span></li>
        </ul>
    </div>
    <div class="featured__item__text">
        <h5>{{$item->title?? 'Không tên'}}</h5>
        <p class="text-muted description">{{$item->description}}</p>
        <h6 class="text-danger d-flex justify-content-between">
            <x-price :item="$item->product_option"></x-price>
        </h6>
    </div>
</div>
