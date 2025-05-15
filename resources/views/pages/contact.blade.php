@extends('layouts.app')
@section('content')
    <!-- Breadcrumb Section Begin -->
    <x-breadcrumb name="lien-he" title="Liên hệ"></x-breadcrumb>
    <!-- Breadcrumb Section End -->
    <section class="contact spad y-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mr-auto">
                    <div class="pr-3">
                        <p class="text-muted"><i>Trong nhịp sống hiện đại, nhu cầu tìm kiếm những món ăn ngon, đặc sản độc đáo và thực phẩm sạch ngày càng được quan tâm. Đó cũng là lý do mà chúng tôi ra đời với sứ mệnh mang đến cho khách hàng những sản phẩm chất lượng cao, đảm bảo vệ sinh an toàn thực phẩm và hương vị tuyệt hảo.</i></p>
                        <h5 class="mb-1 text-black"><span>1. Sứ Mệnh Và Tầm Nhìn</span></h5>
                        <p class="text-muted">Chúng tôi không chỉ đơn thuần là một đơn vị cung cấp thực phẩm mà còn là người bạn đồng hành đáng tin cậy của mọi gia đình. Với mục tiêu trở thành thương hiệu hàng đầu trong lĩnh vực cung cấp món ăn ngon, đặc sản và thực phẩm sạch, chúng tôi cam kết mang đến những sản phẩm đạt chuẩn chất lượng, giàu giá trị dinh dưỡng và bảo vệ sức khỏe người tiêu dùng.</p>
                        <h5 class="mb-1 text-black"><span>2. Quy Trình Lựa Chọn Và Kiểm Định Chất Lượng</span></h5>
                        <p class="text-muted">Mọi sản phẩm đều được tuyển chọn kỹ lưỡng từ các nguồn cung uy tín. Chúng tôi tuân thủ quy trình kiểm định nghiêm ngặt để đảm bảo mọi sản phẩm đến tay khách hàng đều là những sản phẩm an toàn và chất lượng nhất.</p>
                        <h5 class="mb-1 text-black"><span>4. Giá Trị Cam Kết</span></h5>
                        <ul class="list-group ml-3 mb-3 pl-3 text-muted">
                            <li><span>Chất lượng đảm bảo</span></li>
                            <li><span>Nguồn gốc xuất xứ rõ ràng</span></li>
                            <li><span>Giá cả hợp lý</span></li>
                            <li><span>Chăm sóc khách hàng tận tâm</span></li>
                            <li><span>Ưu đãi đặc biệt cho khách hàng thân thiết</span></li>
                        </ul>
                        <h5 class="mb-1 text-black"><span>5. Hướng Tới Sự Phát Triển Bền Vững</span></h5>
                        <p class="text-muted">Chúng tôi không chỉ tập trung vào lợi ích kinh doanh mà còn đặt trọng tâm vào sự phát triển bền vững, bảo vệ môi trường và sức khỏe cộng đồng.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <h3 class="heading">Liên hệ với chúng tôi.</h3>
                        <form class="mb-5" method="post" id="contactForm" name="contactForm" novalidate="novalidate">
                            <div class="row">

                                <div class="col-md-6 form-group">
                                    <label for="name" class="col-form-label">Họ và Tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Nhập họ & tên">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="name" class="col-form-label">Cơ quan</label>
                                    <input type="text" class="form-control" name="organization" id="organization" placeholder="Cơ quan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="email" id="email" placeholder="Nhập vào Email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="message" class="col-form-label">Nội dung cần hổ trợ <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="message" id="message" cols="30" rows="7"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="submit" value="Gửi Liên hệ" class="btn btn-block site-btn rounded-0 py-2 px-4">
                                    <span class="submitting"></span>
                                </div>
                            </div>
                        </form>
                        <div id="form-message-warning mt-4"></div>
                        <div id="form-message-success">
                            Your message was sent, thank you!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
