@props(['sites'])
<div class="hero__search d-flex">
    <div class="hero__search__form flex-grow-1 mr-3">
        <form action="{{Request::root()}}/tim-kiem" method="get">
            <select class="form-select border-0 position-relative z-20 mt-1" name="loai">
                <option class="fs-18 fw-bold" value="1">
                    Tất cả
                </option>
                <option class="fs-18 fw-bold" value="2" {{request('loai') == 2? 'selected': ''}}>
                    <span class="ml-2">Sản Phẩm</span>
                </option>
                <option class="fs-18 fw-bold" value="3" {{request('loai') == 3? 'selected': ''}}>
                    <span class="ml-2">Bài viết</span>
                </option>
            </select>
            <input type="text" placeholder="Nhập từ khóa tìm kiếm" name="tu-khoa" value="{{request('tu-khoa')}}">
            <button type="submit" class="site-btn">Tìm</button>
        </form>
    </div>
    <a class="hero__search__phone flex-shrink-1" href="tel:{{$sites->hotline}}">
        <div class="hero__search__phone__icon">
            <i class="fa fa-phone"></i>
        </div>
        <div class="hero__search__phone__text text-center">
            <h5>0986 88.06.01</h5>
            <div class="text-muted">Hổ trợ <b>24/7</b></div>
        </div>
    </a>
</div>
