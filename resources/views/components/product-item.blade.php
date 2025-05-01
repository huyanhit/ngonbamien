@props(['item' => null])

    <div class="featured__item">
        <a href="{{Request::root()}}/san-pham/{{$item->slug}}" >
            <div class="featured__item__pic set-bg" data-setbg="{{str_replace('ngonbamien', 'thumb_ngonbamien', $item->image->uri)}}">
                <ul class="featured__item__pic__hover">
                    <li><span href="#" title="Yêu thích"><i class="fa fa-heart"></i></span></li>
                    <li><span href="#" title="Nhắn tin"><i class="fa fa-comment"></i></span></li>
                    <li><span href="#" title="Thêm vào giỏ"><i class="fa fa-shopping-cart"></i></span></li>
                </ul>
            </div>
            <div class="featured__item__text">
                <h5>{{$item->title?? 'Không tên'}}</h5>
                <h6 class="text-danger d-flex justify-content-center">
                    @foreach ($item->product_option as $productOptions)
                        <x-price :item="$productOptions"></x-price>
                    @endforeach
                </h6>
            </div>
        </a>
    </div>
