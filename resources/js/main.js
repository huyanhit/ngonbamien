const scroll = document.getElementById("scroll-top");
const VND = new Intl.NumberFormat('vi-VN', {
    style: 'currency',
    currency: 'VND',
});
const cartData = {
    id:0,
    quantity: 1,
    option_id: null,
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
    let header = document.getElementById("header__bot");
    document.onscroll = function() {
        if (header !== null) {
            let sticky = header.offsetTop + 100;
            if (window.pageYOffset > sticky) {
                header.classList.add("sticky");
            } else {
                header.classList.remove("sticky");
            }
        }
    };
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
        '<h4 class="text-center mb-2 text-uppercase"><b>Giỏ hàng</b>' +
        '<a id="close-cart" class="btn btn-sm btn-danger pull-right text-white"><i class="fa fa-close"></i></a>' +
        '</div>' +
        '<div class="my-cart">Loading...</div>' +
        '<div class="text-center mb-2">' +
        '<a href="/gio-hang" class="btn px-3 btn-info text-uppercase text-white mr-2">' +
        '<i class="bi bi-x-circle"></i> Nhập mã giảm giá </a>' +
        '<a class="btn px-3 btn-success text-uppercase" href="/dat-hang">' +
        '<i class="bi bi-cart"></i> Đặt hàng </a>' +
        '</div>' +
        '</div>';
}

function updateCartDom(){
    let html =
        '<table class="table bg-light">'+
        '<tr class="background_pr text-white">'+
        '<th width="10%" class="text-center">Hình ảnh</th>' +
        '<th width="20%">Tên sản phẩm</th>' +
        '<th width="10%" class="text-center">Giá</th>' +
        '<th width="15%" class="text-center">Phân loại</th>' +
        '<th width="10%" class="text-center">Số lượng</th>' +
        '<th width="10%" class="text-center">Tổng cộng</th>' +
        '<th width="10%" class="text-center">Xoá</th>' +
        '</tr>';
    let items = cartDom.items;
    if(Object.keys(items).length > 0){
        for (const index in items) {
            let optionHtml = '';
            let option     = items[index].options;
            if(option.title){
                optionHtml = option.title
            }
            html +=
                '<tr class="align-middle">'+
                '<td class="text-center"><a href="'+items[index].extra_info.link+'">' +
                '<img alt="'+items[index].title+'" onerror="this.src=\'/images/no-image.png\'" ' +
                'src="/admin/get-image-thumbnail/'+items[index].extra_info.image_id+'"/><a></td>' +
                '<td class="align-middle"><a class="d-block" href="'+items[index].extra_info.link+'">'+ items[index].title +'</a></td>' +
                '<td class="text-center align-middle text-danger">'+ VND.format(items[index].price) +' </td>' +
                '<td class="text-center align-middle">'+ optionHtml +'</td>' +
                '<td class="text-center align-middle"><input class="form-control update_quantity"' +
                'data-value="'+items[index].hash+'" type="number" value="'+ items[index].quantity +'"></td>' +
                '<td class="text-center align-middle">'+ VND.format(items[index].price * items[index].quantity) + '</td>' +
                '<td class="text-center align-middle"><a class="btn btn-outline-danger btn-sm text-danger remove-cart" ' +
                'data-value="'+items[index].hash+'">' +
                '<i class="fa fa-minus"></i></a></td>'+
                '</tr>'
        }
    }else{
        html +=
        '<tr class="align-middle">'+
            '<td class="text-center p-2" colspan="7">Không có sản phẩm.</td>'+
        '</tr>';
    }

    html +=
        '<tr class="font-bold background_pr text-white">'+
        '<td class="text-left" colspan="2"><h5 class="text-uppercase pt-1">Tổng cộng</h4></td>' +
        '<td></td>' +
        '<td></td>' +
        '<td class="text-center"><h4 class="text-bold">'+ cartDom.quantities_sum +'</h4></td>' +
        '<td class="text-center"><h4 class="text-bold">'+ VND.format(cartDom.subtotal) +'</h4></td>' +
        '<td></td>' +
        '</tr>';

    html += '</table>';

    let coupon = $('#coupon-down').attr('data-value');

    $('.my-cart').html(html);
    $('#cart-number').html(cartDom.quantities_sum);
    $('#coupon-down').html('-' + VND.format(coupon));
    $('.total-pill').html(VND.format(cartDom.total - (coupon ? parseInt(coupon) : 0)));
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

function removeCart(id){
    if(confirm('Xóa sản phẩm khỏi giỏ hàng?')){
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
    cartData.id        = item.id
    cartData.option_id = item.option
    let html = $(e).html();
    $(e).html('<div class="spinner-border"></div>');
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
    }).fail(function(){
        $(e).html(html);
    });
}

// take in other js page
function flyToElement(flyer, flyingTo) {
    let divider = 6;
    let flyerClone = $(flyer).clone();
    $(flyerClone).css({position: 'absolute', top: $(flyer).offset().top + "px", left: $(flyer).offset().left + "px", opacity: 1, 'z-index': 1000});
    $('body').append($(flyerClone));
    let gotoX = $(flyingTo).offset().left + ($(flyingTo).width() / 2) - ($(flyer).width()/divider)/2;
    let gotoY = $(flyingTo).offset().top + ($(flyingTo).height() / 2) - ($(flyer).height()/divider)/2;

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

function addFavor(e, item) {
    $(e).html('<div class="spinner-border"></div>');
    $.ajax({
        type: 'POST',
        url: '/favor',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: item
    }).done(function(response){
        $(e).html('<i class="fa fa-heart text-danger"></i>');
        if(response.total){
            let itemImg = $(e).parents('.featured__item__pic').find('img').eq(0);
            flyToElement($(itemImg), $('.favor_anchor'));
            $("#favor_count").html(response.total)
        }
    })
}

function chat(e, item) {
    return false
}

$(document).ready(function () {
    $(document).on('click', '#close-cart', function () {
        $("#popover_cart").popover('hide')
    })
    $("#popover_cart").popover({
        html: true,
        container: '.cart-container',
        offset: '0 0',
        content: function () {
            return getCart("my-cart");
        }
    });
    $("#popover_notify").popover({
        html: true,
        container: '.notify-container',
        offset: '0 0',
        content: function () {
            return 'Phiên bản 1.0 release 01/06/2025';
        }
    });

    $(".dropdown-auth").click(function (){
        $(".auth-container").toggleClass('active');
    });

    $('#slider').nivoSlider({
        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
        animSpeed: 2000, // Slide transition speed
        pauseTime: 4000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: false, // Next & Prev navigation
        controlNav: false, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: false // Stop animation while hovering
    });
    $('.service-carousel').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    })
    $('.product-carousel').owlCarousel({
        loop: true,
        margin: 0,
        dots: false,
        responsive: {
            0:{
                items:1,
            },
            900:{
                items:2,
            },
            1000:{
                items:3,
            },
            1200:{
                items:5,
            }
        }
    })
    $('.customer-carousel').owlCarousel({
        loop: true,
        dots: false,
        margin: 0,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    })
    $('.select_price_option').click(function () {
        let id = $(this).attr('data-value');
        $('.select_price_option').removeClass('active');
        $('.product_detail_option').removeClass('active');
        $('.product_detail_'+id).addClass('active');
        $('.select_price_'+id).addClass('active');
    })
    $('.filter__option_ul').on('click', function() {
        $(this).addClass('active');
        $('.filter__list').addClass('active');
        $('.filter__option_grid').removeClass('active');
    });
    $('.filter__option_grid').on('click', function() {
        $(this).addClass('active');
        $('.filter__list').removeClass('active');
        $('.filter__option_ul').removeClass('active');
    });
    $('.add_cart').on('click', function(e) {
        e.preventDefault();
        let itemImg = $(this).parents('.featured__item__pic').find('img').eq(0);
        flyToElement($(itemImg), $('.cart_anchor'));
        addCart(this, {id:$(this).attr('data-value'), option:$(this).attr('option-value')});
    });
    $('.add_favor').on('click', function(e) {
        e.preventDefault();
        addFavor(this, {id: $(this).attr('data-value') });
    });
    $('.as_message').on('click', function(e) {
        e.preventDefault();
        chat(this, {id:$(this).attr('data-value')});
    });
    $('.cart-container').on('click', '.remove-cart', function(e) {
        e.preventDefault();
        removeCart($(this).attr('data-value'));
    });
    $('.cart-container').on('blur', '.update_quantity', function(e) {
        e.preventDefault();
        updateCart(this, $(this).attr('data-value'));
    });

    $('.product__item__price').on('click', function(e) {
        $(this).parent().find('.product__item__price').addClass('hide');
        $(this).parents('.featured__item').find('.add_cart').attr('option-value', $(this).attr('data-value'));
        $(this).removeClass('hide')
    });
    $('#pay_cod').click(function () {
        $('#pay_store_form').hide();
        $('#pay_bank_form').hide();
        $('#pay_cod_form').show();
    })
    $('#pay_store').click(function () {
        $('#pay_cod_form').hide();
        $('#pay_bank_form').hide();
        $('#pay_store_form').show();
    })
    $('#pay_bank').click(function () {
        $('#pay_cod_form').hide();
        $('#pay_store_form').hide();
        $('#pay_bank_form').show();
    })
    $(".show-more").click(function(e) {
        e.preventDefault();
        $(e).toggleClass('active')
        $('.producer_blog').toggleClass('active');
    });
    /*------------------
        Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");

        /*------------------
            Gallery filter
        --------------------*/
        $('.featured__controls li').on('click', function () {
            $('.featured__controls li').removeClass('active');
            $(this).addClass('active');
        });
        if ($('.featured__filter').length > 0) {
            var containerEl = document.querySelector('.featured__filter');
            var mixer = mixitup(containerEl);
        }
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        let bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    //Humberger Menu
    $(".humberger__open").on('click', function () {
        $(".humberger__menu__wrapper").addClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").addClass("active");
        $("body").addClass("over_hid");
    });

    $(".humberger__menu__overlay").on('click', function () {
        $(".humberger__menu__wrapper").removeClass("show__humberger__menu__wrapper");
        $(".humberger__menu__overlay").removeClass("active");
        $("body").removeClass("over_hid");
    });

    /*------------------
		Navigation
	--------------------*/
    $(".mobile-menu").slicknav({
        prependTo: '#mobile-menu-wrap',
        allowParentLinks: true
    });

    /*-----------------------
        Categories Slider
    ------------------------*/
    $(".categories__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 4,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {

            0: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 3,
            },

            992: {
                items: 4,
            }
        }
    });


    $('.hero__categories__all').on('click', function(){
        $('.hero__categories ul').slideToggle(400);
    });

    /*--------------------------
        Latest Product Slider
    ----------------------------*/
    $(".latest-product__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 1,
        dots: false,
        nav: true,
        navText: ["<span class='fa fa-angle-left'><span/>", "<span class='fa fa-angle-right'><span/>"],
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: false
    });

    /*-----------------------------
        Product Discount Slider
    -------------------------------*/
    $(".product__discount__slider").owlCarousel({
        loop: true,
        margin: 0,
        items: 3,
        dots: false,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true,
        responsive: {
            320: {
                items: 1,
            },

            480: {
                items: 2,
            },

            768: {
                items: 2,
            },

            992: {
                items: 3,
            }
        }
    });

    /*---------------------------------
        Product Details Pic Slider
    ----------------------------------*/
    $(".product__details__pic__slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 4,
        dots: true,
        smartSpeed: 1200,
        autoHeight: false,
        autoplay: true
    });

    /*-----------------------
		Price Range Slider
	------------------------ */
    var rangeSlider = $(".price-range"),
        minamount = $("#minamount"),
        maxamount = $("#maxamount"),
        minPrice = rangeSlider.data('min'),
        maxPrice = rangeSlider.data('max');
        rangeSlider.slider({
            range: true,
            min: minPrice,
            max: maxPrice,
            values: [minPrice, maxPrice],
            slide: function (event, ui) {
                minamount.val(ui.values[0]+'k');
                maxamount.val(ui.values[1]+'k');
            }
        });
        minamount.val(rangeSlider.slider("values", 0) +'k');
        maxamount.val(rangeSlider.slider("values", 1) +'k');

    /*--------------------------
        Select
    ----------------------------*/
    $("select").niceSelect();

    /*------------------
		Single Product
	--------------------*/
    $('.product__details__pic__slider img').on('click', function () {
        var imgurl = $(this).data('imgbigurl');
        var bigImg = $('.product__details__pic__item--large').attr('src');
        if (imgurl != bigImg) {
            $('.product__details__pic__item--large').attr({
                src: imgurl
            });
        }
    });

    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });
})
