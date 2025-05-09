@props(['item' => null])
<div class="blog__item">
    <a class="blog__item__pic"  href="{{Request::root()}}/noi-dung/{{$item->slug}}">
        <img src="{{$item->image->uri?? ''}}" alt="{{$item->title}}">
    </a>
    <div class="blog__item__text">
        <ul>
            <li><i class="fa fa-comment"></i> {{$item->view?? 0}} </li>
            <li><i class="fa fa-calendar-o"></i>
                {{\Illuminate\Support\Carbon::parse($item->updated_at)->fromNow()}}
            </li>
        </ul>
        <h5><a href="{{Request::root()}}/noi-dung/{{$item->slug}}">{{$item->title}}</a></h5>
        <p>{{$item->description}}</p>
    </div>
</div>
