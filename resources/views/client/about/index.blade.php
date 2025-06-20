@extends('client.layout.master')

@section('title')
    Về Chúng Tôi
@endsection

@section('content')
<head>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> --}}
</head>

    <!--== Start About Us Area ==-->
   
    <section class="about-us-area py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <h2 class="mb-4">Chào mừng đến với FreakSport</h2>
                        <p>
                            FreakSport là thương hiệu chuyên cung cấp giày thể thao chính hãng với đa dạng mẫu mã
                            và phong cách. Chúng tôi cam kết mang đến cho khách hàng những sản phẩm chất lượng
                            nhất với giá cả hợp lý.
                        </p>
                        <p>
                            Với đội ngũ nhân viên tận tâm và kinh nghiệm lâu năm, FreakSport tự tin đáp ứng mọi
                            nhu cầu của khách hàng từ giày chạy bộ, giày thể thao, giày thời trang đến những sản phẩm
                            độc quyền chỉ có tại cửa hàng của chúng tôi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="{{ asset('client/img/about/1.jpg') }}" alt="FreakSport Store" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End About Us Area ==-->

    <!--== Start Mission Area ==-->
    <section class="mission-area py-5 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="mission-image">
                        <img src="{{ asset('client/img/about/2.jpg') }}" alt="Our Mission" class="img-fluid rounded">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mission-content">
                        <h2 class="mb-4">Sứ Mệnh Của Chúng Tôi</h2>
                        <p>
                            Chúng tôi mong muốn giúp khách hàng tiếp cận với những sản phẩm giày chất lượng cao
                            từ những thương hiệu nổi tiếng trên thế giới. Không chỉ là một cửa hàng bán giày,
                            FreakSport còn là nơi chia sẻ đam mê thể thao, phong cách và xu hướng mới nhất.
                        </p>
                        <p>
                            FreakSport cam kết mang đến trải nghiệm mua sắm tốt nhất cho khách hàng với dịch vụ
                            chăm sóc tận tình, chính sách đổi trả linh hoạt và giao hàng nhanh chóng trên toàn quốc.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Mission Area ==-->

    <!--== Start Team Area ==-->
    <section class="team-area py-5">
        <div class="container text-center">
            <h2 class="mb-5">Đội Ngũ Của Chúng Tôi</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('client/img/about/avatar/son.jpg') }}" style="width: 180px; height: 180px;" alt="CEO" class="img-fluid rounded-circle mb-3">
                        <h4>Trần Thái Sơn</h4>
                        <p>CEO & Founder</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('client/img/about/avatar/cuong.jpg') }}" style="width: 180px; height: 180px;" alt="Manager" class="img-fluid rounded-circle mb-3">
                        <h4>Phạm Mạnh Cường</h4>
                        <p>Quản Lý Cửa Hàng</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="team-member">
                        <img src="{{ asset('client/img/about/avatar/hoang.jpg') }}" style="width: 180px; height: 180px;" alt="Marketing" class="img-fluid rounded-circle mb-3">
                        <h4>Nguyễn Trọng Hoàng</h4>
                        <p>Trưởng Phòng Marketing</p>
                    </div>
                </div>
                
            </div>
            <div class="row mt-5">
                <div class="col-md-6">
                    <div class="team-member ms-5">
                        <img src="{{ asset('client/img/about/avatar/duc.jpg') }}" style="width: 180px; height: 180px;" alt="Marketing" class="img-fluid rounded-circle mb-3">
                        <h4>Trần Minh Đức</h4>
                        <p>Trưởng Phòng Nhân Sự</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="team-member me-5">
                        <img src="{{ asset('client/img/about/avatar/manh.jpg') }}" style="width: 160px; height: 180px;" alt="Marketing" class="img-fluid rounded-circle mb-3">
                        <h4>Trần Duy Mạnh</h4>
                        <p>Trưởng Phòng Kinh Doanh</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!--== End Team Area ==-->



    
   <!--== Start Customer Reviews ==-->
   

<section class="customer-reviews py-5 bg-light">
    <div class="container text-center">
        <h2 class="mb-5">Khách Hàng Nói Gì Về Chúng Tôi?</h2>
        <div class="row">
            @foreach ($reviews as $review)
                <div class="col-md-4">
                    <div class="review-box p-4 bg-white shadow rounded">
                        <div class="d-flex justify-content-center">
                            <span class="text-warning">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="gold" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 .587l3.668 7.431L24 9.748l-6 5.847 1.417 8.273L12 18.896l-7.417 3.972L6 15.595l-6-5.847 8.332-1.73L12 .587z"/>
                                        </svg>
                                    @else
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="gray" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 .587l3.668 7.431L24 9.748l-6 5.847 1.417 8.273L12 18.896l-7.417 3.972L6 15.595l-6-5.847 8.332-1.73L12 .587z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </span>
                        </div>
                        <h5 class="mt-2">{{ $review->title }}</h5>
                        <p class="text-muted">"{{ $review->comment }}"</p>
                        <h6>- {{ $review->user->name }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<!--== End Customer Reviews ==-->
@endsection
