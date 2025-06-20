@extends('client.layout.master')

@section('title')
    Sản phẩm
@endsection

@section('content')
    <!--== Start Product Area Wrapper ==-->
    <section class="product-area product-default-area">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-xl-3">
                    <div class="shop-sidebar">
                        <div class="shop-sidebar-price-range" style="padding: 30px">
                            <h4 class="sidebar-title">Lọc theo giá</h4>
                            <div class="sidebar-price-range">
                                <input type="text" id="amount" readonly
                                    style="border:0;background-color:#fafafa; color:#000000; font-weight:bold;">
                                <div id="price-range"></div>
                                <button id="filter-price" class="mt-3 btn btn-theme btn-sm mt-2"
                                    style=" font-size: 14px;;margin-left: 115px;width: 95px; height: 40px; padding: 10px;"><i
                                        class="fa fa-filter me-2" aria-hidden="true"></i>Lọc</button>
                            </div>
                        </div>
                        <div class="shop-sidebar-category">
                            <h4 class="sidebar-title">Danh mục</h4>
                            <ul>
                                <a href="{{ route('product.index') }}">All</a>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('product.index', ['category' => $category->id]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="shop-sidebar-brand">
                            <h4 class="sidebar-title">Thương hiệu</h4>
                            <div class="sidebar-brand">
                                <ul class="brand-list mb--0">
                                    <a href="{{ route('product.index') }}">All</a>
                                    @foreach ($brands as $brand)
                                        <li>
                                            <a href="{{ route('product.index', ['brand' => $brand->id]) }}">
                                                {{ $brand->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        {{-- <div class="shop-sidebar-price-range">
                            <h4 class="sidebar-title">Lọc theo giá</h4>
                            <div class="sidebar-price-range">
                                <input type="text" id="amount" readonly style="border:0; color:#000000; font-weight:bold;">
                                <div id="price-range"></div>
                                <button id="filter-price" class="mt-3 btn btn-theme btn-sm mt-2"><i
                                        class="fa fa-filter me-2" aria-hidden="true"></i>Lọc</button>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-12">
                            <div class="shop-top-bar">
                                <div class="shop-top-center">
                                    <nav class="product-nav">
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-grid-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-grid" type="button" role="tab" aria-controls="nav-grid"
                                                aria-selected="true"><i class="fa fa-th"></i></button>
                                            <button class="nav-link" id="nav-list-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-list"
                                                aria-selected="false"><i class="fa fa-list"></i></button>
                                        </div>
                                    </nav>
                                </div>
                                <div class="shop-top-right">
                                    <div class="shop-sort">
                                        <form method="GET" action="{{ route('product.index') }}">
                                            {{-- Giữ lại các filter hiện tại --}}
                                            @if(request()->has('category'))
                                                <input type="hidden" name="category" value="{{ request()->category }}">
                                            @endif
                                            @if(request()->has('brand'))
                                                <input type="hidden" name="brand" value="{{ request()->brand }}">
                                            @endif
                                            @if(request()->has('min_price'))
                                                <input type="hidden" name="min_price" value="{{ request()->min_price }}">
                                            @endif
                                            @if(request()->has('max_price'))
                                                <input type="hidden" name="max_price" value="{{ request()->max_price }}">
                                            @endif

                                            <span>Sắp xếp :</span>
                                            <select name="sort" class="form-select d-inline-block w-auto"
                                                onchange="this.form.submit()">
                                                <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Mặc định
                                                </option>
                                                <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Phổ biến</option>
                                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>
                                                    Đánh giá cao</option>
                                                <option value="newness" {{ request('sort') == 'newness' ? 'selected' : '' }}>
                                                    Mới nhất</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-grid" role="tabpanel"
                                    aria-labelledby="nav-grid-tab">
                                    <div class="row">
                                        @if ($products->isEmpty())
                                            <p>Không tìm thấy sản phẩm nào.</p>
                                        @else
                                            @foreach ($products as $product)
                                                <div class="col-sm-6 col-lg-4">
                                                    <!--== Start Product Item ==-->
                                                    <div class="product-item">
                                                        <div class="inner-content">
                                                            <div class="product-thumb">
                                                                <a
                                                                    href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
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
                                                                    <form class="add-wishlist-form"
                                                                        action="{{ route('wishlist.add', $product->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $product->id }}">
                                                                        <button type="submit" class="btn-product-wishlist">
                                                                            <i class="fa fa-heart"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                                <a class="banner-link-overlay"
                                                                    href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}"></a>
                                                            </div>
                                                            <div class="product-info">
                                                                <div class="category">
                                                                    <ul>
                                                                        <li><a
                                                                                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <h4 class="title"><a
                                                                        href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                                </h4>
                                                                <div class="prices">
                                                                    @if ($product->discount)
                                                                        <span
                                                                            class="price-old">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                        <span class="sep">-</span>
                                                                        <span
                                                                            class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100), 2) }}đ</span>
                                                                    @else
                                                                        <span
                                                                            class="price text-danger">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--== End Product Item ==-->
                                                </div>
                                                {{ $products->links() }}
                                            @endforeach
                                        @endif

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">

                                    <div class="row">

                                        @foreach ($products as $product)
                                            <div class="col-md-12">
                                                <!--== Start Product Item ==-->
                                                <div class="product-item product-list-item">
                                                    <div class="inner-content">
                                                        <div class="product-thumb product-thumb-list">
                                                            <a
                                                                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">
                                                                @if ($product->imageLists->isNotEmpty())
                                                                    <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                                    width="270" height="274" alt="{{ $product->name }}">
                                                                @endif
                                                            </a>

                                                            @if ($product->discount)
                                                                <div class="product-flag">
                                                                    <ul>
                                                                        <li class="discount">-{{ $product->discount }}%
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif



                                                            <a class="banner-link-overlay"
                                                                href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}"></a>
                                                        </div>
                                                        <div class="product-info">
                                                            <div class="category">
                                                                <ul>
                                                                    <li><a
                                                                            href="#">{{ $product->category->name ?? 'Uncategorized' }}</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <h4 class="title"><a
                                                                    href="{{ route('product.detail', ['id' => $product->id, 'slug' => $product->slug]) }}">{{ $product->name }}</a>
                                                            </h4>
                                                            <div class="prices">

                                                                @if ($product->discount)
                                                                    <span
                                                                        class="price-old">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                    <span class="sep">-</span>
                                                                    <span
                                                                        class="price text-danger">{{ number_format($product->variants->min('price') * (1 - $product->discount / 100), 2) }}đ</span>
                                                                @else
                                                                    <span
                                                                        class="price text-danger">{{ number_format($product->variants->min('price'), 2) }}đ</span>
                                                                @endif

                                                            </div>
                                                            <p>{!! Str::limit($product->description, 100) !!}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{ $products->links() }}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('administrator/js/product.js') }}"></script>
    @vite('resources/js/brand.js')
    @vite('resources/js/category.js')
    @vite('resources/js/product/list.js')

    <!--== End Product Area Wrapper ==-->
@endsection