@props(['name' => '', 'title' => '','data' => null])
<section class="breadcrumb-section set-bg" data-setbg="{{Request::root()}}/img/breadcrumb.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2 class="text-white"> {{$title}}</h2>
                    <div class="breadcrumb__option">
                        {{ Breadcrumbs::render($name, $data) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
