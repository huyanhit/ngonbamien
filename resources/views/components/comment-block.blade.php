@props(['data' => null, 'comments'=> null])
<div class="form-horizontal bg-white border" id="comment">
    <h4 class="font-bold text-xl text-uppercase text-center mt-3">Thảo luận</h4>
    <ul id="comment_list" class="list-group px-3">
        @foreach($comments as $item)
            <li class="comment-item border my-2 list-group-item">
                <div class="d-flex">
                    <span class="mr-2 flex-grow-0 font-weight-bold">{{$item->name}}</span>
                    <div class="product__details__rating flex-grow-1"></div>
                    <div class="flex-shrink-1 text-muted"> {{\Illuminate\Support\Carbon::parse($item->created_at)->format('H:i d-m-Y')}} </div>
                </div>
                <div class="comment_content text-muted">{!! $item->content !!}</div>
            </li>
        @endforeach
    </ul>
    <div class="row">
        {!! $comments->links('vendor.pagination.bootstrap-4') !!}
    </div>
    <div id="comment_form" class="bg-white border m-3 p-3">
        @if(auth()->check())
            <div class="form-group row">
                <label class="col-4 col-form-label text-right">Tên <span class="text-danger">*</span></label>
                <div class="col-8">
                    <input class="form-control" id="comment_name" type="text" placeholder="Nhập tên hoặc biệt danh"
                           value="{{auth()->user()->name}}">
                    <span id="comment_name_error" class="text-danger text-xs hidden"></span>
                </div>
            </div>
        @else
            <div class="form-group row">
                <label class="col-4 col-form-label text-right">Tên <span class="text-danger">*</span></label>
                <div class="col-8">
                    <input class="form-control" id="comment_name" type="text" placeholder="Nhập tên hoặc biệt danh">
                    <span id="comment_name_error" class="text-danger text-xs hidden"></span>
                </div>
            </div>
        @endif
        <div class="form-group row">
            <label class="col-4 col-form-label text-right">Thảo luận <span class="text-danger">*</span></label>
            <div class="col-8">
               <textarea class="form-control"
                         id="comment_content" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                <span id="comment_content_error" class="text-danger text-xs hidden"></span>
            </div>
        </div>
        <div class="text-center">
            <button class="btn primary-btn rounded-0" onclick="comment()"> Gửi </button>
        </div>
    </div>

    <script>
        function checkEmptyValue(elem, label, data, message){
            if(data === ''){
                elem.addClass('border-1 border-red-700');
                label.removeClass('hidden');
                label.text(message);
                return true;
            }
            elem.removeClass('border-1 border-red-700');
            label.addClass('hidden');
            label.text('');

            return false;
        }
        function checkPhone(elem, label, data, message){
            if(data === '' || data.length < 10  || data.length > 12){
                elem.addClass('border-1 border-red-700');
                label.removeClass('hidden');
                label.text(message);
                return true;
            }
            elem.removeClass('border-1 border-red-700');
            label.addClass('hidden');
            label.text('');

            return false;
        }
        function comment(){
            let name = $('#comment_name');
            let content = $('#comment_content');
            let nameError = $('#comment_name_error');
            let contentError = $('#comment_content_error');

            let data = {
                {{isset($data['product_id'])?'product_id:'.$data['product_id'].',':''}}
                    {{isset($data['post_id'])?'post_id:'.$data['post_id'].',':''}}
                name: name.val()?? '',
                content: content.val().trim()
            }

            if( !checkEmptyValue(name, nameError, data.name, 'Bạn chưa nhập tên') &&
                !checkEmptyValue(content, contentError, data.content, 'Bạn chưa nhập đánh giá')){
                ajaxComment(data);
            }
        }
        function ajaxComment(data){
            $.ajax({
                type: 'post',
                url: '/ax-post-comment',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data
            }).done(function(data){
                renderComment(data);
            });
        }
        function renderComment(data) {
            $('#comment_list').append(
                '<li class="comment-item border my-2 list-group-item">' +
                '<div class="d-flex">' +
                '<span class="mr-2 flex-grow-0 font-weight-bold"> ' + data.name + ' </span>' +
                '<div class="product__details__rating flex-grow-1">' +
                '</div>' +
                '<div class="flex-shrink-1 text-muted"> ' + data.created_at + ' </div>' +
                ' </div>' +
                '<div class="comment_content text-muted">' + data.content + '</div>' +
                '</li>'
            )
        }
    </script>
</div>
