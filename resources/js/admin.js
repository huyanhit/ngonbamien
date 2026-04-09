$(document).ready(function(){
    // list js
    $("#ajax_send").hide();

    $(document).on("click", function() {
        ajax_update_field();
    });

    $(document).on('keypress',function(e) {
        if(e.which == 13) ajax_update_field();
    });

    function renderArea(element) {
        let data  = $(element).find('span').html();
        $(element).html('<textarea class="form-control" id="update_text_change"  data="'+data+'" type="area">' + data
        + '</textarea><script>CKEDITOR.replace( \'update_text_change\', {customConfig: \'myconfig.js\'});</script>');
    };

    function renderSelect(element) {
        let id    = $(element).find('span').attr('uid');
        let value = $(element).find('span').text();
        let data  = JSON.parse($(element).attr('data'));
        let html  = '<select id="update_text_change" class="form-control" key="'+ id +'" data="'+ value +'">';
        Object.keys(data).forEach(function(key) {
            if(id == key){
                html += '<option value="'+key+'" selected>'+ data[key] +'</option>';
            }else{
                html += '<option value="'+key+'">'+ data[key] +'</option>';
            }
        })
        html += '</select>';

        $(element).html(html);
    }

    function ajax_update_field() {
        let element  = $('#update_text_change');
        let parent = element.parent();
        if(element.length && parent.length){
            let type   = parent.attr('type');
            let id     = parent.attr('uid');
            let field  = parent.attr('field');

            let oldValue = element.attr('data');
            let value    = element.val();

            if(type  == 'select') oldValue = element.attr('key');
            if(type  == 'area') value = CKEDITOR.instances.update_text_change.getData();
            if(value == oldValue){
                restore_update_field(parent, type, oldValue);
            }else{
                if(type == 'image_id' || type == 'image' || type == 'file'){
                    ajax_update_form(id, field, element, value, oldValue);
                }else{
                    ajax_update_data(id, field, element, value, oldValue);
                }
            }
        }
    }

    function restore_update_field(element, type, oldValue){
        if(type == 'select'){
            let value_select = $('#update_text_change option:selected').text();
            element.html('<span class="inline" uid="'+oldValue+'">'+value_select+'</span>');
        }else if(type == 'file'){
            element.html('<span>'+ oldValue +'</span>');
        }else if(type == 'area'){
            element.html('<span class="inline">'+ oldValue +'</span>');
        }else{
            element.html('<span class="inline">'+ oldValue +'</span>');
        }

        $("#ajax_send").hide();
    }

    function ajax_update_form(id, field, element, value, oldValue) {
        let urlUpload = window.location.pathname+'/'+id;
        let file      = element[0].files[0];
        let type      = element.parent().attr('type');
        let src       = element.attr('data');
        let parent    = element.parent();
        let token     = $('input[name="_token"]').val();
        if(file === undefined){
            if(type == 'image' || type == 'image_id'){
                parent.html('<span><img src="'+ src +'"></span>');
            }else if(type == 'file'){
                parent.html('<span>'+ src +'</span>');
            }
            return false;
        }

        let formData  = new FormData();
        formData.append('_method', 'PUT');
        formData.append(field, file);

        $.ajax({
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            url: urlUpload,
            data: formData,
            processData: false,
            contentType: false,
        }).done(function(){
            if(type == 'image' || type == 'image_id'){
                parent.html('<span><img src="'+ URL.createObjectURL(file) +'"></span>');
            }else if(type == 'file'){
                parent.html('<span>'+ data +'</span>');
            }
        }).fail(function(response){
            if(type == 'image'){
                parent.html('<span><img src="'+ oldValue +'"></span>');
            }else if(type == 'file'){
                parent.html('<span>'+ data +'</span>');
            }

            let res = JSON.parse(response.responseText);
            if(res.message != undefined) alert(res.message);
            $("#ajax_send").hide();
        });
    }

    function ajax_update_data(id, field, element, value, oldValue) {
        let url    = window.location.pathname+'/'+id;
        let parent = element.parent();
        let type   = parent.attr('type');
        let token  = $('input[name="_token"]').val();

        $.ajax({
            type: 'PUT',
            url: url,
            data: {'_token':token, [field]: value}
        }).done(function(){
            if(type === 'select'){
                let id_select    = element.val();
                let value_select = $('#update_text_change option:selected').text();
                parent.html('<span class="inline badge bg-danger" uid="'+id_select+'">'+value_select+'</span>');
            }else if(type === 'area'){
                parent.html('<span class="inline">'+ value +'</span>');
            }else if(type === 'text'){
                parent.html('<span class="inline">'+ value +'</span>');
            }
        }).fail(function(response){
            let res = JSON.parse(response.responseText);
            if(res.message != undefined) alert(res.message);
            $("#ajax_send").hide();
        });
    }

    function uploadImages(element) {
        console.log(element);
        let files     = $(element)[0].files;
        let key       = $(element).attr('key');
        let multiple  = $(element).prop('multiple');
        let html      = '';

        Array.from(files).forEach(file => {
            html += '<img onerror="this.src=\'/images/no-image.png\'" src="'+ URL.createObjectURL(file) +'"> '
        });
        (multiple)? $('.image_box_'+key).append(html): $('.image_box_'+key).html(html);
    }

    function deleteImages(element) {
        $.ajax({
            type: 'PUT',
            url: $(element).attr('url'),
            data:{
                _token: $('input[name="_token"]').val(),
                delete_images: $(element).attr('fid'),
            }
        }).done(function(){
            element.remove();
        })
    }

    $('.ajax_delete').click(function(){
        let url   = this.getAttribute( "url" );
        let token = $('input[name="_token"]').val();
        if(!confirm("Do you want to delete?")){
            return false;
        }
        $.ajax({
            type: 'DELETE',
            url: url,
            data:{
                _token:token,
            }
        }).done(function(){
            window.location.reload(false);
        });
    });

    $('#list .check-list input[type="checkbox"]').click(function(){
        let id    = this.getAttribute( "fid" );
        let field = this.getAttribute( "name" );
        let value = $(this).is(':checked')? 1: 0;
        ajax_update_data(id, field, $(this), value, null);
    });

    $('.can_update_text').dblclick(function(event){
        let type = $(this).attr('type');
        let child = $('#update_text_change');
        if(child.length){
            if($(this).find('#update_text_change').length) {
                event.stopPropagation();
            }else{
                ajax_update_field();
            }
        }else{
            if(type == 'select'){
                renderSelect(this);
            }else if(type == 'image_id' || type == 'image' || type == 'file'){
                $(this).html('<input class="form-control" id="update_text_change" type="file" data="'+ $(this).find('img').attr('src')+'">' );
            }else if(type == 'area'){
                renderArea(this);
            }else{
                $(this).html('<input id="update_text_change" class="form-control" type="text" data="'+ $(this).find('span').html() +'" value="'+ $(this).text().trim()+'">' );
            }
        }
        event.stopPropagation();
    });

    $('select.render_select').change(function(){
        let reference = $(this).attr('reference');
        let element = $(document).find('select[name="'+reference+'"]');
        if(element.length > 0) {
            let id = $(this).val();
            let table = $(this).attr('table');
            let url = $('.prefix_link').attr('href') + '/getPostSelect/' + table + '/' + id;
            $.ajax({
                type: 'GET',
                url: url,
            }).done(function (response) {
                let element = $(document).find('select[name="' + reference + '"]');
                let html = '<select class="form-control select" name="' + reference + '">';
                html += '<option value=""> Choose </option>';
                Object.keys(response).forEach(function (key) {
                    html += '<option value="' + key + '">' + response[key] + '</option>';
                })
                html += '</select>';

                $(element).html(html);
            });
        }
    });

    $('.can_update_text').on("click", function(){
        if($(this).find('#update_text_change').length) event.stopPropagation();
    });

    $('.upload_images_field').on('change', function () {
        uploadImages(this);
    });

    $('.images-delete').on('click', function () {
        deleteImages(this);
    });
});

$(document).ready(function(){
    function applyCheckAll(){
        $("#delete_all").prop('disabled', true);
        $("#hide_all").prop('disabled', true);
        $("#active_all").prop('disabled', true);
        $("input[name='check']").each((item, elem)=>{
            if($(elem).is(':checked')){
                $("#delete_all").prop('disabled', false);
                $("#hide_all").prop('disabled', false);
                $("#active_all").prop('disabled', false);
            }
        })
    }

    function getIdsCheckAll(){
        let ids = [];
        $("input[name='check']").each((item, elem)=>{
            if($(elem).is(':checked')){
                ids.push($(elem).attr('data'))
            }
        })

        return ids;
    }

    function ajaxUpdateAll(process){
        let ids   = getIdsCheckAll();
        let url   = location.href;
        let token = $('input[name="_token"]').val();
        if(!confirm("Do you want to "+process+" All?")){
            return false;
        }
        $.ajax({
            type: 'POST',
            url: url,
            data:{
                _token:token,
                ids: ids,
                process_mutil_record: process
            }
        }).done(function(){
            window.location.reload();
        });
    }

    function ajaxChangeOrder(){
        let token   = $('input[name="_token"]').val();
        let url     = $("#change_order_submit").attr('url');
        let name    = $("#order_name").val();
        let phone   = $("#order_phone").val();
        let note    = $("#order_note").val();
        let address = $("#order_address").val();

        $.ajax({
            type: 'PUT',
            url: url,
            data:{
                _token:token,
                name: name,
                phone: phone,
                note: note,
                address: address,
            }
        }).done(function(){
            window.location.reload();
        });
    }

    function ajaxCancelOrder(){
        let token   = $('input[name="_token"]').val();
        let url     = $("#cancel_order_submit").attr('url');
        if(!confirm("Do you want to cancel order?")){
            return false;
        }
        $.ajax({
            type: 'PUT',
            url: url,
            data:{
                _token: token,
                order_status_id: 8,
            }
        }).done(function(){
            window.location.reload();
        });
    }

    function ajaxUpdateStatus(){
        let token   = $('input[name="_token"]').val();
        let url     = $("#change_order_status_submit").attr('url');
        let name    = $("#order_status_id").val();
        let note    = $("#order_note").val();
        let address = $("#order_address").val();

        $.ajax({
            type: 'PUT',
            url: url,
            data:{
                _token:token,
                name: name,
                phone: phone,
                note: note,
                address: address,
            }
        }).done(function(){
            window.location.reload();
        });
    }

    $("#change_order_submit").click(function () {
        ajaxChangeOrder();
    });

    $("#cancel_order_submit").click(function () {
        ajaxCancelOrder();
    });

    $('#checkAll').click(function () {
        $("input[name='check']").prop('checked', this.checked);
        applyCheckAll();
    });

    $("input[name='check']").click(()=>{
       applyCheckAll();
    })

    $("#active_all").click(()=>{
       ajaxUpdateAll('actives');
    })
    $("#hide_all").click(()=>{
       ajaxUpdateAll('un-actives');
    })
    $("#delete_all").click(()=>{
       ajaxUpdateAll('deletes');
    })
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

$(document).ajaxSend(function() {
    $("#ajax_send").show();
});

$(document).ajaxSuccess(function() {
    $("#ajax_send").delay(1000).hide(0);
});
