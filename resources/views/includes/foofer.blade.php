<!-- Footer Section Begin -->
<footer class="footer spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__about__logo">
                        <a href="./index.html">
                            <img src="{{$sites->image->uri?? 'img/logo.png'}}" alt="{{$sites->meta_title?? ''}}"/>
                        </a>
                    </div>
                    <ul>
                        <li>Address: {{$sites->address ?? ''}}</li>
                        <li>Phone: {{$sites->phone ?? ''}}</li>
                        <li>Email: {{$sites->email ?? ''}}</li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                <div class="footer__widget">
                    <h6>Thông tin website</h6>
                    <ul>
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Dịch vụ</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                        <li><a href="#">Liên hệ</a></li>
                        <li><a href="#">Bảo mật</a></li>
                        <li><a href="#">Site Map</a></li>
                    </ul>
                    <ul>
                        <li><a href="#">Hướng dẫn mua hàng</a></li>
                        <li><a href="#">Hướng dẫn thanh toán</a></li>
                        <li><a href="#">Thông tin vận chuyển</a></li>
                        <li><a href="#">Quy định hoàn tiền</a></li>
                        <li><a href="#">Hóa đơn điện tử</a></li>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="footer__widget">
                    <h6>Đăng ký Nhận thông báo</h6>
                    <p>Để chúng tôi gửi các thông tin hửu ích đến bạn.</p>
                    <form action="#">
                        <input type="text" placeholder="Nhập Email của bạn">
                        <button type="submit" class="site-btn">Đăng ký</button>
                    </form>
                    <div class="footer__widget__social">
                        <a href="{{ $sites->link_facebook ?? '#'}}"><i class="fa fa-facebook"></i></a>
                        <a href="{{ $sites->link_youtube ?? '#'}}"><i class="fa fa-youtube"></i></a>
                        <a href="{{ $sites->link_tiktok ?? '#'}}"><svg style="height: 15px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M16 8.24537V15.5C16 19.0899 13.0899 22 9.5 22C5.91015 22 3 19.0899 3 15.5C3 11.9101 5.91015 9 9.5 9C10.0163 9 10.5185 9.06019 11 9.17393V12.3368C10.5454 12.1208 10.0368 12 9.5 12C7.567 12 6 13.567 6 15.5C6 17.433 7.567 19 9.5 19C11.433 19 13 17.433 13 15.5V2H16C16 4.76142 18.2386 7 21 7V10C19.1081 10 17.3696 9.34328 16 8.24537Z"></path></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright">
                    <div class="footer__copyright__text">
                        <p>
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                            <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://ngombamien.com" target="_blank">ngombamien</a>
                        </p>
                    </div>
                    <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->
