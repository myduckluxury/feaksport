@extends('client.layout.master')

@section('title')
    Giày thể thao chất
@endsection

@section('content')
    <!--== Start Hero Area Wrapper ==-->
    @include('client.layout.partials.carousel')
    <!--== End Hero Area Wrapper ==-->

    <!--== Start Product Collection Area Wrapper ==-->
    <section class="product-area product-collection-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <!--== Start Product Collection Item ==-->
                    <div class="product-collection">
                        <div class="inner-content">
                            <div class="product-collection-content">
                                <div class="content">
                                    <h3 class="title"><a href="{{ route('product.index') }}">Giày thể thao</a></h3>
                                </div>
                            </div>
                            <div class="product-collection-thumb"
                                data-bg-img="{{ asset('client/img/shop/banner/3.webp') }}"></div>
                            <a class="banner-link-overlay" href="{{ route('product.index') }}"></a>
                        </div>
                    </div>
                    <!--== End Product Collection Item ==-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--== Start Product Collection Item ==-->
                    <div class="product-collection">
                        <div class="inner-content">
                            <div class="product-collection-content">
                                <div class="content">
                                    <h3 class="title"><a href="{{ route('product.index') }}">Giày mới nhất</a></h3>
                                </div>
                            </div>
                            <div class="product-collection-thumb" data-bg-img="{{ asset('client/img/shop/banner/1.jpg')}}">
                            </div>
                            <a class="banner-link-overlay" href="{{ route('product.index') }}"></a>
                        </div>
                    </div>
                    <!--== End Product Collection Item ==-->
                </div>
                <div class="col-lg-4 col-md-6">
                    <!--== Start Product Collection Item ==-->
                    <div class="product-collection">
                        <div class="inner-content">
                            <div class="product-collection-content">
                                <div class="content">
                                    <h3 class="title"><a href="{{ route('product.index') }}">Giày công sở</a></h3>
                                </div>
                            </div>
                            <div class="product-collection-thumb" data-bg-img="{{ asset('client/img/shop/banner/2.jpg') }}">
                            </div>
                            <a class="banner-link-overlay" href="{{ route('product.index') }}"></a>
                        </div>
                    </div>
                    <!--== End Product Collection Item ==-->
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Collection Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
        <div class="container pt--0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">Sản phẩm nổi bật</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-6 col-lg-3">
                        <!--== Start Product Item ==-->
                        <div class="product-item">
                            <div class="inner-content">
                                <div class="product-thumb">
                                    <a href="{{ route('product.detail', ['id' => $product->id, 'slug' =>$product->slug]) }}">
                                        @if ($product->imageLists->isNotEmpty())
                                            <img src="{{ Storage::url($product->imageLists->first()->image_url) }}" width="270"
                                                height="274" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    @if ($product->discount > 0)
                                        <div class="product-flag">
                                            <ul>
                                                <li class="discount">-{{ $product->discount }}%</li>
                                            </ul>
                                        </div>
                                    @endif
                                    <div class="product-action">
                                        <a class="btn-product-wishlist" href="#"><i class="fa fa-heart"></i></a>
                                    </div>
                                    <a class="banner-link-overlay" href="{{route('product.detail', ['id' => $product->id, 'slug' =>$product->slug])}}"></a>
                                </div>
                                <div class="product-info">
                                    <div class="category">
                                        <ul>
                                            <li><a
                                                    href="{{route('product.detail', ['id' => $product->id, 'slug' =>$product->slug])}}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <h4 class="title"><a
                                            href="{{ route('product.detail',['id' => $product->id, 'slug' =>$product->slug]) }}">{{ $product->name }}</a>
                                    </h4>
                                    <div class="prices">
                                        @if ($product->discount > 0)
                                            <span class="price-old">{{ number_format($product->variants->min('price')) }}đ</span>
                                            <span class="sep">-</span>
                                            <span class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100)) }}đ</span>
                                        @else
                                            <span class="price text-danger">{{ number_format($product->variants->min('price')) }}đ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--== End Product Item ==-->
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->

    <!--== Start Divider Area Wrapper ==-->
    <section class="bg-color-f2 position-relative z-index-1">
        <div class="container pt--0 pb--0">
            <div class="row divider-wrap divider-style1">
                <div class="col-lg-6">
                    <div class="divider-content" data-title="NEW">
                        <h4 class="sub-title">Tiết kiệm 50%</h4>
                        <h2 class="title">Tất cả cửa hàng trực tuyến</h2>
                        <p class="desc">Khuyến mãi có sẵn tất cả giày dép và sản phẩm</p>
                        <a class="btn-theme" href="{{ route('product.index') }}">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-layer-wrap">
            <div class="bg-layer-style z-index--1 parallax" data-speed="1.05"
                data-bg-img="{{ asset('client/img/photos/giày-thể-thao-nam-mới-nhất-2-1.jpg')}}">
            </div>
        </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-best-seller-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">Bán chạy nhất</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-slider-wrap">
                        <div class="swiper-container product-slider-col4-container">
                            <div class="swiper-wrapper">
                                @foreach ($sellWell as $product)
                                    <div class="swiper-slide">
                                        <!--== Start Product Item ==-->
                                        <div class="product-item">
                                            <div class="inner-content">
                                                <div class="product-thumb">
                                                    <a href="{{ route('product.detail', ['id' => $product->id, 'slug' =>$product->slug]) }}">
                                                        @if ($product->imageLists->isNotEmpty())
                                                            <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                                width="270" height="274" alt="{{ $product->name }}">
                                                        @endif
                                                    </a>
                                                    @if ($product->discount > 0)
                                                        <div class="product-flag">
                                                            <ul>
                                                                <li class="discount">-{{ $product->discount }}%</li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <div class="product-action">
                                                        <a class="btn-product-wishlist" href="#"><i class="fa fa-heart"></i></a>
                                                    </div>
                                                    <a class="banner-link-overlay" href="{{route('product.detail', ['id' => $product->id, 'slug' =>$product->slug])}}"></a>
                                                </div>
                                                <div class="product-info">
                                                    <div class="category">
                                                        <ul>
                                                            <li><a
                                                                    href="{{route('product.detail', ['id' => $product->id, 'slug' =>$product->slug])}}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4 class="title"><a
                                                            href="">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="prices">
                                                        @if ($product->discount > 0)
                                                            <span class="price-old">{{ number_format($product->variants->min('price')) }}đ</span>
                                                            <span class="sep">-</span>
                                                            <span class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100)) }}đ</span>
                                                        @else
                                                            <span class="price text-danger">{{ number_format($product->variants->min('price')) }}đ</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--== End Product Item ==-->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!--== Add Swiper Arrows ==-->
                        <div class="product-swiper-btn-wrap">
                            <div class="product-swiper-btn-prev">
                                <i class="fa fa-arrow-left"></i>
                            </div>
                            <div class="product-swiper-btn-next">
                                <i class="fa fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Area Wrapper ==-->

    <!--== Start Divider Area Wrapper ==-->
    <section>
        <div class="container pt--0 pb--0">
            <div class="row flex-md-row-reverse justify-content-between divider-wrap divider-style2">
                <div class="col-lg-6">
                    <div class="divider-thumb-content">
                        <div class="thumb">
                            <a href="shop.html">
                                <img src="{{ asset('client/img/shop/banner/1.webp')}}" width="570" height="350"
                                    alt="Image-HasTech">
                            </a>
                        </div>
                        <div class="content">
                            <h2 class="title">Giày thể thao</h2>
                            <p class="desc">Giảm giá 30% cho tất cả các loại giày</p>
                            <a class="btn-theme" href="{{ route('product.index') }}">Xem ngay</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="divider-thumb-content">
                        <div class="thumb">
                            <a href="shop.html">
                                <img src="{{ asset('client/img/shop/banner/2.webp')}}" width="570" height="700"
                                    alt="Image-HasTech">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Divider Area Wrapper ==-->

<!--== Start Blog Area Wrapper ==-->
<section class="blog-area blog-default-area mt-3 mb-5" style="max-width: 1600px; margin: 0 auto;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center">
                    <h3 class="title">Blog mới nhất</h3>
                    <p class="subtitle">Cập nhật tin tức, mẹo vặt và xu hướng mới nhất.</p>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($blogs->isNotEmpty())
                @foreach ($blogs as $blog)
                    <div class="col-md-6 col-lg-4">
                        <!--== Start Blog Item ==-->
                        <div class="post-item">
                            <div class="thumb">
                                <a href="{{ route('blog.detail', $blog->id) }}">
                                    <img src="{{ asset('storage/' . $blog->image_url) }}" class="blog-img" alt="{{ $blog->title }}">
                                </a>
                            </div>
                            <div class="content">
                                <div class="meta-post">
                                    <ul>
                                        <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</li>
                                        <li><i class="fa fa-user"></i> {{ $blog->author }}</li>
                                    </ul>
                                </div>
                                <h4 class="title">
                                    <a href="{{ route('blog.detail', $blog->id) }}">{{ $blog->title }}</a>
                                </h4>
                                <p class="excerpt">{{ Str::limit($blog->content, 100) }}</p>
                                <a class="btn-theme" href="{{ route('blog.detail', $blog->id) }}">Đọc thêm</a>
                            </div>
                        </div>
                        <!--== End Blog Item ==-->
                    </div>
                @endforeach
            @else
                <h4 class="text-center text-muted">Chưa có bài viết nào.</h4>
            @endif
        </div>
    </div>
</section>
<!--== End Blog Area Wrapper ==-->

<style>
    /*== BLOG STYLES ==*/
    .blog-area {
        background: #fdf3f0;
        padding: 60px 0;
    }

    .section-title .title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #d84315;
        margin-bottom: 15px;
    }

    .section-title .subtitle {
        font-size: 1rem;
        color: #555;
        margin-bottom: 30px;
    }

    .post-item {
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .post-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .post-item .thumb img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .content {
        padding: 20px;
        flex-grow: 1;
    }

    .meta-post ul {
        list-style: none;
        padding: 0;
        margin: 0 0 10px;
        display: flex;
        justify-content: space-between;
        font-size: 14px;
        color: #777;
    }

    .meta-post ul li i {
        margin-right: 5px;
        color: #ff5722;
    }

    .post-item .title {
        font-size: 1.4rem;
        font-weight: bold;
        margin: 10px 0;
        color: #d84315;
        transition: color 0.3s;
    }

    .post-item .title a {
        text-decoration: none;
        color: inherit;
    }

    .post-item .title a:hover {
        color: #ff5722;
    }

    .excerpt {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
    }

    .post-btn {
        display: inline-block;
        background: #ff5722;
        color: #fff;
        padding: 8px 15px;
        font-size: 14px;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .post-btn:hover {
        background: #e64a19;
    }

    @media (max-width: 768px) {
        .section-title .title {
            font-size: 1.8rem;
        }

        .post-item .title {
            font-size: 1.2rem;
        }
    }
</style>




@endsection