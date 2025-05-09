@props(['data' => null])
<div class="form-horizontal bg-white border p-3" id="comment">
    <h4 class="font-bold text-xl text-uppercase text-center mt-3">Đánh giá</h4>
    <div id="comment_list"></div>
    <div class="bg-white p-3">
        <div class="form-group row">
            <div class="col-4 text-right text-muted"> Đánh giá </div>
            <div class="col-8">
                <div class="rating d-flex justify-content-end flex-row-reverse w-[110px]">
                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" class="mr-1" title="5 star"></label>
                    <input type="radio" id="star4" name="rating" checked value="4" /><label for="star4" class="mr-1" title="4 star"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" class="mr-1" title="3 star"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" class="mr-1" title="2 star"></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" class="mr-1" title="1 star"></label>
                </div>
                <span id="comment_rating_error" class="text-danger text-xs hidden"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label text-right">Tên hoặc biệt danh</label>
            <div class="col-8">
                <input class="form-control" id="comment_name" type="text" placeholder="Nhập tên hoặc biệt danh">
                <span id="comment_name_error" class="text-danger text-xs hidden"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label text-right">Nhập SĐT đã mua hàng</label>
            <div class="col-8">
                <input class="form-control" id="comment_phone" type="number" placeholder="0123456789">
                <span id="comment_phone_error" class="text-danger text-xs hidden"></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-4 col-form-label text-right">Đánh giá</label>
            <div class="col-8">
               <textarea class="form-control"
                         id="comment_content" rows="3" placeholder="Nhập đánh giá của bạn"></textarea>
                <span id="comment_content_error" class="text-danger text-xs hidden"></span>
            </div>
        </div>
        <div class="text-center">
            <button class="btn primary-btn rounded-0" onclick="comment()"> Đánh giá </button>
        </div>
    </div>

    <script>
        // loadComment();

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
            let phone = $('#comment_phone');
            let rating = $('[name="rating"]:checked');
            let content = $('#comment_content');
            let nameError = $('#comment_name_error');
            let phoneError = $('#comment_phone_error');
            let ratingError = $('#comment_rating_error');
            let contentError = $('#comment_content_error');

            let data = {
                {{isset($data['product_id'])?'product_id:'.$data['product_id'].',':''}}
                {{isset($data['service_id'])?'service_id:'.$data['service_id'].',':''}}
                name: name.val().trim(),
                phone: phone.val().trim(),
                rating: rating.val(),
                content: content.val().trim()
            }

            if( !checkEmptyValue(name, nameError, data.name, 'Bạn chưa nhập tên') &&
                !checkPhone(phone, phoneError, data.phone, 'Số điện thoại không hợp lệ') &&
                !checkEmptyValue(rating, ratingError, data.rating, 'Bạn chưa bình chọn') &&
                !checkEmptyValue(content, contentError, data.content, 'Bạn chưa nhập đánh giá')){
                ajaxComment(data);
            }
        }

        function renderComment(data){
            let rating = '';
            for (let i = 0; i < 5; i++){
                let color = (data.rating > i)?' text-yellow-500':'';
                rating += '<i class="mr-1 bi bi-star-fill'+color+'"></i>';
            }
            $('#comment_list').append('<div class="border-1 bg-white mt-3 p-3"><div class="flex flex-row">'+
                '<span class="flex-auto font-bold inline-block">'+
                '<h5 class="inline uppercase">'+data.name+'</h5>'+
                '<span class="items-center mx-2 inline">'+ rating +'</span>'+
                '</span>'+
                '<span class="flex-auto text-right text-gray-700 text-xs ">'+data.created_at+'</span>'+
                '</div>'+
                '<p class="clear-both text-gray-700 text-sm mt-2">'+data.content+'</p></div>')
        }

        function ajaxComment(data){
            $.ajax({
                type: 'post',
                url: '/ax-comment',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: data
            }).done(function(data){
                renderComment(data);
            });
        }

        function loadComment(){
            @php $param = isset($data['product_id'])?'?product_id='.$data['product_id']:'?service_id='.$data['service_id'] @endphp
            $.ajax({
                type: 'get',
                url: '/ax-load-comment{{$param}}',
            }).done(function(response){
                for (let i in response.data){
                    renderComment(response.data[i])
                }
            });
        }
    </script>
</div>
