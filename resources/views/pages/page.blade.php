@extends('layouts.app')
@section('content')
    <x-breadcrumb name="xem-trang" title="{{$pages->title}}" :data="['page_router' => $pages->router, 'page_title' => $pages->title]"></x-breadcrumb>
    <div class="container">
        <div class="page-content">
            @if(!empty($pages))
                <article>
                    <h1 class="text-center my-2"> {{$pages->title}} </h1>
                    <div class="description border rounded text-muted p-3">
                        {!! $pages->description !!}
                    </div>
                    <div class="my-2">
                        {!! $pages->content !!}
                    </div>
                </article >
            @else
                <article class="my-2">
                    Trang đang hoàn thiện. Cảm ơn quý khách đã ghé thăm.
                </article >
            @endif
        </div>
    </div>
@endsection

