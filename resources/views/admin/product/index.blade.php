@extends('admin.layout.master')

@section('title')
    Danh sách sản phẩm
@endsection

@section('content')
    <!-- Table Start -->
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách sản phẩm</h6>
                <div class="row mb-2 justify-content-between">
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('admin-product.index') }}">
                            <div class="input-group input-group-sm">
                                <input class="form-control" name="keyword" type="text"
                                    placeholder="Tìm kiếm mã hoặc tên sản phẩm" value="{{ request('keyword') }}">
                                <button type="submit" class="input-group-text bg-primary text-light"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form><br>
                    </div>

                    <div class="col-md-6">
                        <form action="{{ route('admin-product.index') }}" method="get">
                            <div class="d-flex align-items-center">
                                <div class="w-75 me-2 d-flex input-group-sm">
                                    <select class="form-select me-2" name="brand_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($brands as $brand)
                                            <option {{ request('brand_id') == $brand->id ? 'selected' : '' }} value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select><br>

                                    <select class="form-select" name="category_id">
                                        <option value="">Tất cả</option>
                                        @foreach ($categories as $category)
                                            <option {{ request('category_id') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="mb-2">
                    <a href="{{ route('admin-product.create') }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus me-1"></i>Thêm mới</a>
                </div>

                <div class="table-responsive bg-white p-2">
                    @if ($products->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mã sản phẩm</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th>Số biến thể</th>
                                    <th>Số lượng</th>
                                    <th>Lượt bán</th>
                                    <th>Thương hiệu</th>
                                    <th>Danh mục</th>
                                    <th scope="col" style="width: 10%" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $index => $product)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $product->sku }}</td>
                                        <td>
                                            @if ($product->imageLists->isNotEmpty())
                                                <img src="{{ Storage::url($product->imageLists->first()->image_url) }}"
                                                    class="rounded" width="100" alt="">
                                            @else
                                                Chưa có ảnh nào.
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->variants->count() }}</td>
                                        <td>{{ $product->variants->sum('quantity') }}</td>
                                        <td>{{ $product->sales_count }}</td>
                                        <td>{{ $product->brand->name }}</td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin-product.detail', $product->id) }}"
                                                    class="btn text-primary" title="Chi tiết sản phẩm"><i
                                                        class="fas fa-info-circle fa-lg"></i></a>
                                                <a href="{{ route('product-variant.index', $product->id) }}"
                                                    class="btn text-success" title="Biến thể sản phẩm"><i class="fas fa-boxes"></i></a>
                                                @if ($product->variants->isEmpty())
                                                    <form action="{{ route('admin-product.delete', $product->id) }}"
                                                        method="post" class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn text-danger"
                                                            onclick="return confirm('Bạn có muốn xóa sản phẩm này.')"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h2>Chưa có sản phẩm nào</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/product/list.js')
@endsection
