import './bootstrap';
import './main.js';
const scroll = document.getElementById("scroll-top");
const VND = new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
});
const cartData = {
    id:0,
    quantity: 1,
    options: {}
}
let cartDom = null;

window.onscroll = function() {
    myBox()
    mySticky()
    //scrollFunction()
};

axGetCart();

function showOrder(elem){
    if($(elem).is(":checked")){
        $("#order-area").show(300)
    }else {
        $("#order-area").hide(300)
    }
}

function scrollComment(){
    window.scrollTo(0, document.getElementById('comment').offsetTop  - 100);
}

function myBox() {
    const contain = document.getElementById("box-contain");
    const box = document.getElementById("box-tv");
    if(contain !== null && box  !== null){
        const top = contain.offsetTop - 100;
        const bot = contain.offsetHeight + contain.offsetTop - box.offsetHeight - 100;

        if (window.pageYOffset > top && window.pageYOffset < bot) {
            contain.classList.add("top");
            contain.classList.remove("bot");
        } else if(window.pageYOffset > bot) {
            contain.classList.add("bot");
            contain.classList.remove("top");
        }else{
            contain.classList.remove("bot");
            contain.classList.remove("top");
        }
    }
}

function mySticky() {
    const header = document.getElementById("header-fixed");
    if(header){
        const sticky = header.offsetTop;
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
        } else {
            header.classList.remove("sticky");
        }
    }
}

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        scroll.style.display = "block";
    } else {
        scroll.style.display = "none";
    }
}

function backHistory(){
    if(window.location.pathname !== '/'){
        window.history.back()
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

function axGetCart(){
    if(cartDom == null){
        $.ajax({
            type: 'GET',
            url: '/cart',
            contentType: "application/json",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).done(function(response){
            cartDom = response;
            updateCartDom();
        });
    }else {
        setTimeout(function() { updateCartDom() }, 10);
    }
}

function getCart() {
    axGetCart();
    return '<div> ' +
        '<div class="text-lg font-bold text-center mb-2">Giỏ hàng</div>' +
        '<div class="my-cart">Loading...</div>' +
        '<div class="text-right">' +
        '<a id="close-cart" class="btn px-2 mr-2 rounded-2 bg-cyan-500 text-white hover:bg-cyan-700 text-sm">' +
        '<i class="bi bi-x-circle"></i> Đóng </a>' +
        '<a class="btn px-2 rounded-2 bg-red-500 text-white hover:bg-red-600 text-sm" href="/dat-hang">' +
        '<i class="bi bi-cart"></i> Đặt hàng </a>' +
        '</div>' +
        '</div>';
}

function updateCartDom(){
    let html =
        '<table class="table border-1">'+
        '<tr class="bg-cyan-700 text-white">'+
        '<th width="20%" class="text-center">Hinh ảnh</th>' +
        '<th width="30%">Tên sản phẩm</th>' +
        '<th width="10%" class="text-center">Số lượng</th>' +
        '<th width="10%" class="text-center">Giá</th>' +
        '<th width="20%" class="text-center">Lựa chọn</th>' +
        '<th width="10%" class="text-center">Xoá</th>' +
        '</tr>';
    let items = cartDom.items;
    for (const index in items) {
        let optionHtml = '';
        let option = items[index].options;
        if(option.title){
            optionHtml = option.group_title +': '+ option.title
        }
        html +=
            '<tr class="align-middle">'+
            '<td class="text-center"><a href="'+items[index].extra_info.link+'"><img class="inline-block w-[100px]" alt="'+items[index].title+'" ' +
            'onerror="this.src=\'/images/no-image.png\'" ' +
            'src="/admin/get-image-thumbnail/'+items[index].extra_info.image_id+'"/><a></td>' +
            '<td><a class="text-cyan-600" href="'+items[index].extra_info.link+'">'+ items[index].title +'<a></td>' +
            '<td class="text-center"><input onblur="updateCart(this, \''+items[index].hash+'\')" type="number" value="'+ items[index].quantity +'"></td>' +
            '<td class="text-center">'+ VND.format(items[index].price) +' </td>' +
            '<td class="text-center">'+ optionHtml +'</td>' +
            '<td class="text-center"><a class="flex-auto cursor-pointer" ' +
            'onclick="removeCart(\''+items[index].hash+'\',\''+items[index].title+'\')">' +
            '<i class="bi bi-x-circle text-red-600"></i> </a></td>'+
            '</tr>'
    }
    html +=
        '<tr class="font-bold bg-cyan-700 text-white">'+
        '<td class="text-center"> Tổng cộng </td>' +
        '<td></td>' +
        '<td class="text-center">'+ cartDom.quantities_sum +'</td>' +
        '<td class="text-center"><span class="text-red-600">'+ VND.format(cartDom.subtotal) +'</span></td>' +
        '<td></td>' +
        '<td></td>' +
        '</tr>';

    html += '</table>';

    $('.my-cart').html(html);
    $('#cart-number').html(cartDom.quantities_sum);
    $('#total-pill').html(VND.format(cartDom.subtotal - parseInt($('#coupon-down').text())));
}

function showNavigation() {
    const menus = document.getElementById("menus");
    if (menus.classList.contains("lg:hidden")) {
        menus.classList.remove("lg:hidden");
        menus.classList.remove("lg:hidden");
    } else {
        menus.classList.add("lg:hidden");
    }
}

function closeSubMenu(){
    $('#menus li').each((index, elem) =>{
        $(elem).removeClass("active");
        $(elem).find('i.bi-chevron-left').removeClass('bi-chevron-left')
        $(elem).find('i.bi-chevron-left').addClass('bi-chevron-right')
    })
}

function openSubMenu(e){
    if ($(e).parents('.menu-item').hasClass("active")) {
        $(e).removeClass('bi-chevron-left')
        $(e).addClass('bi-chevron-right')
        $(e).parents('.menu-item').removeClass("active");
    } else {
        closeSubMenu();
        $(e).removeClass('bi-chevron-right')
        $(e).addClass('bi-chevron-left')
        $(e).parents('.menu-item').addClass("active");
    }
}

function updateCart(e, id) {
    $.ajax({
        type: 'PUT',
        url: '/cart/'+ id,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data:{
            "quantity": $(e).val(),
        }
    }).done(function(response){
        cartDom = response;
        updateCartDom();
    });
}

function removeCart(id, title){
    if(confirm('Xóa sản phẩm '+ title +' khỏi giỏ hàng?')){
        $.ajax({
            type: 'DELETE',
            url: '/cart/'+id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        }).done(function(response){
            cartDom = response;
            updateCartDom();
        });
    }
}

function updateCartOptions(elem, options) {
    cartData.options = options
    $('.options-items').removeClass('bg-cyan-700 text-white');
    $(elem).addClass('bg-cyan-700 text-white');
    if(options.price && options.price > 0){
        $('#price_product').text(VND.format(options.price))
    }
}

function addCart(e, item, link = ''){
    cartData.id =  item.id
    let html = $(e).html();
    $(e).html('<div class="spinner-border h-[15px] w-[15px]"></div>');
    $.ajax({
        type: 'POST',
        url: '/cart',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: cartData
    }).done(function(response){
        $(e).html(html);
        cartDom = response;
        updateCartDom();
        if(link !== ''){
            window.location.href = '/'+link;
        }
    }).error(function(){
        $(e).html(html);
    });
}

function flyToElement(flyer, flyingTo) {
    var divider = 6;
    var flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    var gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    var gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

    $(flyerClone).animate({
            opacity: 0.4,
            left: gotoX,
            top: gotoY,
            width: $(flyer).width()/divider,
            height: $(flyer).height()/divider
        }, 700,
        function () {
            $(flyingTo).fadeOut('fast', function () {
                $(flyingTo).fadeIn('fast', function () {
                    $(flyerClone).fadeOut('fast', function () {
                        $(flyerClone).remove();
                    });
                });
            });
        });
}

$(document).ready(function() {
    $('.add-cart').on('click', function() {
        var itemImg = $(this).parents('.product_item').find('img').eq(0);
        flyToElement($(itemImg), $('.cart_anchor'));
    });
});
