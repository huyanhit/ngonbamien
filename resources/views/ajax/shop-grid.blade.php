<section class="product background margin_15">
    <div class="container">
        <div class="filter__item">
            <div class="row">
                <div class="col-lg-3 col-md-5">
                    <form class="sidebar" method="get" action="{{Request::url()}}">
                        <div class="sidebar__item">
                            <h4>Giá bán</h4>
                            <select class="form-select w-100 mb-3" name="gia" onchange="this.form.submit()">
                                <option value=""> Chọn mức giá </option>
                                <option value="duoi-100k" {{request('gia') === 'duoi-100k' ? 'selected': ''}}> Dưới 100.000đ </option>
                                <option value="100k-200k" {{request('gia') === '100k-200k' ? 'selected': ''}}> 100.000đ đến 200.000đ </option>
                                <option value="200k-500k" {{request('gia') === '200k-500k' ? 'selected': ''}}> 200.000đ đến 500.000đ </option>
                                <option value="tren-500k" {{request('gia') === 'tren-500k' ? 'selected': ''}}> Trên 500.000đ </option>
                                <option value="lien-he" {{request('gia') === '5' ? 'selected': ''}}> Liên hệ </option>
                            </select>
                        </div>
                        <div class="sidebar__item">
                            <h4>Vùng miền</h4>
                            <select class="form-select w-100 mb-3" name="xuat-xu" onchange="this.form.submit()">
                                <option value=""> Chọn vùng </option>
                                @foreach ($producers as $item)
                                    <option value="{{$item->slug}}" {{request('xuat-xu') == $item->slug ? 'selected': ''}}>
                                        {{$item->title}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="sidebar__item mt-2">
                            <h4>Danh mục</h4>
                            <div class="sidebar__item__size">
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-moi'? 'active': ''}}"
                                        name="loai"
                                        value="mon-moi"
                                        type="submit">
                                        Món mới
                                </button>
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-mua-nhieu'? 'active': ''}}"
                                        name="loai"
                                        value="mon-mua-nhieu"
                                        type="submit">
                                        Món mua nhiều
                                </button>
                                <button
                                        class="btn btn-outline-dark my-1 {{request('loai') === 'dang-khuyen-mai'? 'active': ''}}"
                                        name="loai"
                                        value="dang-khuyen-mai"
                                        type="submit">
                                        Đang khuyến mãi
                                </button>
                                <button class="btn btn-outline-dark my-1  {{request('loai') === 'mon-da-thich'? 'active': ''}}"
                                        name="loai"
                                        value="mon-da-thich"
                                        type="submit">
                                        Món đã thích
                                </button>
                                <button class="btn btn-outline-dark my-1 {{request('loai') === 'mon-da-mua'? 'active': ''}}"
                                        name="loai"
                                        value="mon-da-mua"
                                        type="submit">
                                        Món đã mua
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-9 col-md-7">
                    <div class="row" style="padding: 0 5px">
                        <div class="col-lg-4 col-sm-5">
                            <div class="filter__sort">
                                <span>Sắp xếp</span>
                                <select>
                                    <option value="1">Theo giá</option>
                                    <option value="2">Theo tên</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-4">
                            <div class="filter__found">
                                <h6><span>{{$products->total()}}</span> Sản phẩm </h6>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-3">
                            <div class="filter__option">
                                <span class="icon_ul filter__option_ul"></span>
                                <span class="icon_grid-2x2 filter__option_grid active"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row filter__list" style="padding: 0 5px">
                        @foreach ($products as $item)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <x-product-item-single :item="$item"/>
                            </div>
                        @endforeach
                    </div>
                    <div class="pull-right">
                        {!! $products->links('vendor.pagination.bootstrap-4') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

