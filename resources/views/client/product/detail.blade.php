@extends('client.layout.master')

@section('title')
    Chi tiết sản phẩm
@endsection

@section('content')
    {{-- {{ dd($reviews) }} --}}
    {{-- @dd($reviews->items()) --}}
    <!--== Start Product Single Area Wrapper ==-->
    <section class="product-area product-single-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="product-single-item">
                        <div class="row">
                            <div class="col-xl-6">
                                <!--== Start Product Thumbnail Area ==-->
                                <div class="product-single-thumb">
                                    <div class="swiper-container single-product-thumb single-product-thumb-slider">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->imageLists as $image)
                                                <div class="swiper-slide">
                                                    <a class="lightbox-image" data-fancybox="gallery"
                                                        href="{{ asset('client/img/shop/product-single/1.webp') }}">
                                                        <img src="{{ Storage::url($image->image_url ?? '') }}"
                                                            width="570" height="541" alt="Image-HasTech">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="swiper-container single-product-nav single-product-nav-slider">
                                        <div class="swiper-wrapper">
                                            @foreach ($product->imageLists as $image)
                                                <div class="swiper-slide">
                                                    <img src="{{ Storage::url($image->image_url) }}" width="127"
                                                        height="127" alt="{{ $product->name }}">
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                                <!--== End Product Thumbnail Area ==-->
                            </div>
                            <div class="col-xl-6">
                                <!--== Start Product Info Area ==-->
                                <div class="product-single-info">
                                    <h3 class="main-title">{{ $product->name }}</h3>
                                    <div class="prices">
                                        @if ($product->discount)
                                            <span
                                                class="price text-danger">{{ str_replace(',', '.', number_format($product->variants->min('price') * (1 - $product->discount / 100))) }}
                                                VND</span>
                                        @else
                                            <span
                                                class="price text-danger">{{ str_replace(',', '.', number_format($product->variants->min('price'))) }}
                                                VND</span>
                                        @endif
                                    </div>

                                    <div class="rating-box-wrap">
                                        <div class="rating-box">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="review-status">
                                            <a href="javascript:void(0)">(5 Đánh giá của khách hàng)</a>
                                        </div>
                                    </div>
                                    <form id="add-to-cart" action="{{ route('cart.add', $product->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" name="color" id="selected-color">
                                        <input type="hidden" name="size" id="selected-size">
                                        <input type="hidden" id="product-discount" value="{{ $product->discount }}">

                                        <p id="stock-status">Chọn màu và size</p>
                                        <ul class="quantity-list">
                                            @foreach ($product->variants as $variant)
                                                <li class="quantity-option" data-color="{{ strtolower($variant->color) }}"
                                                    data-size="{{ strtolower($variant->size) }}"
                                                    data-quantity="{{ $variant->quantity }}">
                                                </li>
                                            @endforeach
                                        </ul>

                                        <script></script>
                                        <div class="product-color">
                                            <h6 class="title">Màu</h6>
                                            <ul class="color-list">
                                                @foreach ($product->variants->unique('color') as $variant)
                                                    @php
                                                        $sizes = $product->variants
                                                            ->where('color', $variant->color)
                                                            ->pluck('size')
                                                            ->implode(',');
                                                    @endphp
                                                    <li class="color-option" data-color="{{ strtolower($variant->color) }}"
                                                        data-size="{{ $sizes }}" data-price="{{ $variant->price }}"
                                                        style="background-color: {{ $variant->color }}">
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>

                                        <div class="product-size">
                                            <h6 class="title">Size</h6>
                                            <ul class="size-list">
                                                @foreach ($product->variants->unique('size')->sortBy('size') as $variant)
                                                    <li class="size-option" data-size="{{ strtolower($variant->size) }}"
                                                        data-color="{{ $variant->color }}"
                                                        data-price="{{ $variant->price }}">
                                                        {{ $variant->size }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <style>
                                            .color-option.selected,
                                            .size-option.selected {
                                                border: 2px solid black;
                                                opacity: 1;
                                            }

                                            .color-option.disabled,
                                            .size-option.disabled {
                                                opacity: 0.5;
                                                pointer-events: none;
                                            }
                                        </style>
                                        <div class="product-quick-action">
                                            <div class="qty-wrap">
                                                <div class="pro-qty">
                                                    <div class="d-flex">
                                                        <div
                                                            class= "dec qty-btn d-flex align-items-center justify-content-center">
                                                            -</div>
                                                        <input type="text" title="Quantity" name="quantity"
                                                            value="1">
                                                        <div
                                                            class="inc qty-btn d-flex align-items-center justify-content-center">
                                                            +</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn-theme">Thêm vào giỏ hàng</button>
                                        </div>

                                    </form>

                                    <form id="add-wishlist" action="{{ route('wishlist.add', $product->id) }}"
                                        method="POST">
                                        @csrf
                                        {{-- Thêm vào yêu thích --}}
                                        <div class="product-wishlist-compare">
                                            <button type="submit"
                                                class="text-decoration-none btn btn-link text-danger p-3">
                                                <i class="pe-7s-like fa-lg"></i> Thêm vào yêu thích
                                            </button>
                                        </div>
                                    </form>

                                    <div class="product-info-footer">
                                        <div class="social-icons">
                                            <span>Chia sẻ</span>
                                            <a href="#"><i class="fa fa-facebook"></i></a>
                                            <a href="#"><i class="fa fa-dribbble"></i></a>
                                            <a href="#"><i class="fa fa-pinterest-p"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <!--== End Product Info Area ==-->
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="product-review-tabs-content">
                        <ul class="nav product-tab-nav" id="ReviewTab" role="tablist">
                            <li role="presentation">
                                <a id="description-tab" class="nav-link active" data-bs-toggle="pill"
                                    href="#description" role="tab" aria-controls="description"
                                    aria-selected="true">Mô tả</a>
                            </li>
                            <li role="presentation">
                                <a id="reviews-tab" class="nav-link" data-bs-toggle="pill" href="#reviews"
                                    role="tab" aria-controls="reviews" aria-selected="false">Đánh
                                    giá<span>(05)</span></a>
                            </li>
                        </ul>
                        <div class="tab-content product-tab-content" id="ReviewTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <div class="product-description">
                                    <p>{!! $product->description !!}</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="product-review-content">
                                    <div class="review-content-header">
                                        <h3>Đánh giá của khách hàng</h3>

                                        <div class="review-info d-flex align-items-center justify-content-between flex-wrap"
                                            style="gap: 16px;">
                                            <div class="d-flex align-items-center" style="gap: 12px;">
                                                <ul class="review-rating mb-0">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= floor($averageRating))
                                                            <li class="fa fa-star"></li>
                                                        @elseif ($i - $averageRating <= 0.5)
                                                            <li class="fa fa-star-half-o"></li>
                                                        @else
                                                            <li class="fa fa-star-o"></li>
                                                        @endif
                                                    @endfor
                                                </ul>
                                                <span class="review-caption mb-0"
                                                    style="margin-top: 15px; margin-left: -10px;">Dựa trên
                                                    {{ $totalReviews }} đánh giá</span>
                                            </div>

                                            <form id="filter-rating-form" class="mb-3">
                                                <label for="rating">Lọc theo số sao:</label>
                                                <select name="rating" id="rating" class="form-select"
                                                    style="width: 150px; display: inline-block;">
                                                    <option value="">Tất cả</option>
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}"
                                                            {{ request('rating') == $i ? 'selected' : '' }}>
                                                            {{ $i }} sao
                                                        </option>
                                                    @endfor
                                                </select>
                                            </form>

                                            <span class="review-write-btn">Viết bài đánh giá</span>
                                        </div>

                                    </div>

                                    <!--== Start Reviews Form Item ==-->
                                    <div class="reviews-form-area">
                                        <h4 class="title">Viết bài đánh giá</h4>
                                        <div class="reviews-form-content">
                                            @if (Auth::check())
                                                @if ($hasPurchased && $order)
                                                    @if (session('success'))
                                                        <div class="alert alert-success">{{ session('success') }}</div>
                                                    @endif

                                                    @if (session('error'))
                                                        <div class="alert alert-danger">{{ session('error') }}</div>
                                                    @endif

                                                    @foreach ($orderItems as $index => $item)
                                                        @php
                                                            $variant = $item->product_variant;
                                                            $product = $variant->product;

                                                        @endphp
                                                        <form
                                                            action="{{ route('reviews.store', ['product_id' => $product->id]) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="row">
                                                                {{-- Tên --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="for_name">Họ và tên</label>
                                                                        <input id="for_name" class="form-control"
                                                                            type="text" name="name"
                                                                            value="{{ Auth::user()->name }}" readonly>
                                                                    </div>
                                                                </div>

                                                                {{-- Email --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="for_email">Email</label>
                                                                        <input id="for_email" class="form-control"
                                                                            type="email" name="email"
                                                                            value="{{ Auth::user()->email }}" readonly>
                                                                    </div>
                                                                </div>

                                                                {{-- Xếp hạng --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <span class="title">Xếp hạng</span>
                                                                        <div class="review-rating"
                                                                            data-index="{{ $index }}">
                                                                            <span class="star"
                                                                                data-value="1">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="2">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="3">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="4">&#9733;</span>
                                                                            <span class="star"
                                                                                data-value="5">&#9733;</span>
                                                                        </div>
                                                                        <input type="hidden" name="rating"
                                                                            id="rating-value-{{ $index }}">
                                                                    </div>
                                                                </div>

                                                                {{-- Thông tin sản phẩm --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Loại giày</label>
                                                                        <input class="form-control" type="text"
                                                                            value="{{ $item->product_name }}" readonly>

                                                                        <label for="">Size</label>
                                                                        <input class="form-control" type="text"
                                                                            value="{{ $item->size }}" readonly>

                                                                        <label>Màu</label>
                                                                        <div class="d-flex align-items-center">
                                                                            <span class="color-box"
                                                                                style="width: 20px; height: 20px; background-color: {{ $item->color }};
                                                                                        display: inline-block; margin-left: 10px; border: 1px solid #ccc;
                                                                                        border-radius: 50%;">
                                                                            </span>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="for_images">Tải lên hình ảnh sản
                                                                                phẩm bạn đã nhận (tối đa 3 ảnh)</label>

                                                                            <input type="file" name="images[]"
                                                                                class="form-control image-input"
                                                                                id="for_images_{{ $index }}"
                                                                                multiple>
                                                                            <div class="image-preview mt-2"
                                                                                id="preview-{{ $index }}"></div>
                                                                            @error('images.*')
                                                                                <div class="text-danger">{{ $message }}
                                                                                </div>
                                                                            @enderror
                                                                        </div>
                                                                        {{-- Hidden inputs --}}
                                                                        <input type="hidden" name="product_variant_id"
                                                                            value="{{ $item->product_variant_id }}">
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $item->product_variant->product_id }}">
                                                                        <input type="hidden" name="order_id"
                                                                            value="{{ $item->order_id }}">
                                                                    </div>
                                                                </div>

                                                                {{-- Mô tả --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="for_title">Tiêu đề</label>
                                                                        <input type="text" id="for_title"
                                                                            name="title" class="form-control" required>

                                                                        <label for="for_comment">Mô tả Đánh giá</label>
                                                                        <textarea id="for_comment" class="form-control" name="comment" placeholder="Viết đánh giá của bạn ở đây"></textarea>
                                                                    </div>
                                                                </div>

                                                                {{-- Nút gửi --}}
                                                                <div class="col-md-12">
                                                                    <div class="form-submit-btn">
                                                                        <button type="submit" class="btn-submit">Đăng
                                                                            bình luận</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-warning">
                                                        Bạn phải mua sản phẩm này trước khi để lại đánh giá.
                                                    </div>
                                                @endif
                                            @else
                                                <div class="alert alert-warning">
                                                    Vui lòng <a href="{{ route('signin') }}">đăng nhập</a> để lại đánh
                                                    giá.
                                                </div>
                                            @endif

                                        </div>
                                    </div>


                                    <div class="reviews-content-body" id="review-list">

                                        @forelse($reviews->items() as $review)
                                            <!--== Start Reviews Content Item ==-->
                                            <div class="review-item">
                                                <ul class="review-rating">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <li
                                                            class="fa {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }}">
                                                        </li>
                                                    @endfor
                                                </ul>
                                                @php
                                                    // Lấy thông tin từ order_items theo review
                                                    $item = \App\Models\OrderItem::where('order_id', $review->order_id)
                                                        ->where('product_variant_id', $review->product_variant_id)
                                                        ->first();
                                                @endphp

                                                <h5>
                                                    {{ $item ? $item->product_name : $review->product->name ?? 'Sản phẩm không tồn tại' }}
                                                </h5>

                                                @php
                                                    // Lấy thông tin từ order_items theo review
                                                    $item = \App\Models\OrderItem::where('order_id', $review->order_id)
                                                        ->where('product_variant_id', $review->product_variant_id)
                                                        ->first();
                                                @endphp
                                                @if ($item)
                                                    <div style="display: flex; align-items: center; gap: 12px;">
                                                        <p style="margin: 0;"><strong>Size:</strong> {{ $item->size }}
                                                        </p>
                                                        <p style="margin: 0; display: flex; align-items: center;">
                                                            <strong style="margin-right: 4px;">Màu:</strong>
                                                            <span class="color-box"
                                                                style="width: 20px; height: 20px; background-color: {{ $item->color }}; border-radius: 50%; display: inline-block; border: 1px solid gray"></span>
                                                        </p>
                                                    </div>
                                                @endif
                                                <h5 class="sub-title">
                                                    <span>{{ $review->user->name ?? 'Anonymous' }}</span>
                                                    vào ngày <span>{{ $review->created_at->format('d \t\h\á\n\g m, Y') }}</span>
                                                </h5>
                                                <h3 class="title">{{ $review->title }}</h3>
                                                <p>{{ $review->comment }}</p>

                                                {{-- Hiển thị ảnh nếu có --}}
                                                @if ($review->images)
                                                    <div class="review-images">
                                                        @foreach (json_decode($review->images) as $image)
                                                            <img src="{{ Storage::url($image) }}" alt="Hình ảnh đánh giá"
                                                                class="review-image" onclick="openImageModal(this.src)"
                                                                style="max-width: 150px; margin: 5px; border-radius: 5px; cursor: pointer;">
                                                        @endforeach
                                                    </div>
                                                @endif


                                                <div id="imageModal" onclick="closeImageModal()"
                                                    style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; 
                                                            background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center;">
                                                    <img id="modalImage" src="" alt="Phóng to ảnh"
                                                        style="max-width: 90%; max-height: 90%; border-radius: 8px;">
                                                </div>
                                            </div>
                                            <!--== End Reviews Content Item ==-->
                                        @empty
                                            <p>Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
                                        @endforelse
                                        <script></script>

                                        <style>
                                            #loading-screen {
                                                position: fixed;
                                                top: 0;
                                                left: 0;
                                                width: 100%;
                                                height: 100%;
                                                background: linear-gradient(135deg, #f5f5f5, #e0e0e0);
                                                display: flex;
                                                justify-content: center;
                                                align-items: center;
                                                z-index: 9999;
                                                visibility: hidden;
                                            }

                                            .hide-loading {
                                                visibility: hidden;
                                            }

                                            .review-images {
                                                display: flex;
                                                flex-wrap: wrap;
                                                gap: 10px;
                                            }

                                            .review-image {
                                                max-height: 100px;
                                                object-fit: cover;
                                            }
                                        </style>

                                    </div>




                                    <!--== Start Reviews Pagination Item ==-->
                                    <div class="review-pagination">
                                        {{ $reviews->links('pagination::bootstrap-4') }}
                                    </div>
                                    <!--== End Reviews Content Item ==-->

                                    <!--== Start Reviews Content Item ==-->


                                    <!--== Start Reviews Pagination Item ==-->
                                    <div class="review-pagination">
                                        <span class="pagination-pag">1</span>
                                        <span class="pagination-pag">2</span>
                                        <span class="pagination-next">Kế tiếp "</span>
                                    </div>
                                    <!--== End Reviews Pagination Item ==-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--== End Product Single Area Wrapper ==-->

    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-best-seller-area">
        <div class="container pt--0">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="title">Sản phẩm tương tự</h3>
                        <div class="desc">
                            <p>Có rất nhiều sản phẩm có sẵn</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-slider-wrap">
                        <div class="swiper-container product-slider-col4-container">
                            <div class="swiper-wrapper">
                                @foreach ($products as $product)
                                    <div class="swiper-slide">
                                        <div class="product-item">
                                            <div class="inner-content">
                                                <div class="product-thumb">
                                                    <a
                                                        href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                                        <img src="{{ Storage::url($product->imageLists->first()?->image_url) }}"
                                                            width="270" height="274" alt="{{ $product->name }}">
                                                    </a>
                                                    <div class="product-action">
                                                        <a class="btn-product-wishlist" href="#"><i
                                                                class="fa fa-heart"></i></a>
                                                        <a class="btn-product-cart" href="#"><i
                                                                class="fa fa-shopping-cart"></i></a>
                                                        <button type="button" class="btn-product-quick-view-open">
                                                            <i class="fa fa-arrows"></i>
                                                        </button>
                                                        <a class="btn-product-compare" href="#"><i
                                                                class="fa fa-random"></i></a>
                                                    </div>
                                                    <a class="banner-link-overlay"
                                                        href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}"></a>//
                                                </div>
                                                <div class="product-info">
                                                    <div class="category">
                                                        <ul>
                                                            <li><a
                                                                    href="#">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <h4 class="title">
                                                        <a
                                                            href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="prices">
                                                        <span
                                                            class="price text-danger">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

    <script>
        var cartIndexUrl = "{{ route('cart.index') }}";
        let productDiscount = @json($product->discount);
        const productId = {{ $id }}
    </script>
    <script src="{{ asset('administrator/js/product.detail.js') }}"></script>
    @vite('resources/js/product/detail.js')
    @vite('resources/js/product-variant.js')

@endsection
