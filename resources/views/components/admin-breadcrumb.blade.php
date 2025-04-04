@props(['name'=>'','data' => null])
<div class="page-title-box d-sm-flex align-items-center justify-content-between">
    @if(isset($data['title']))<h4 class="mb-sm-0"> {{$data['title']}} </h4> @endif
    <div class="page-title-right -m-3">
        {{ Breadcrumbs::render($name, $data) }}
    </div>
</div>