@extends('admin.layout.master')

@section('title')
    Biến thể sản phẩm - {{ $product->name }}
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách biến thể - {{ $product->name }}</h6>
                <div class="mb-4 text-start">
                    <a href="{{ route('admin-product.detail', $product->id) }}" class="btn btn-sm btn-secondary"><i
                            class="fas fa-arrow-left me-2"></i>Sản phẩm</a>
                    <a href="{{ route('product-variant.create', $product->id) }}" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus me-2"></i>Thêm mới</a>
                </div>
                <div class="table-responsive">
                    @if ($variants->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th>Tên sản phẩm</th>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Kích cỡ</th>
                                    <th scope="col">Giá</th>
                                    <th>Số lượng</th>
                                    <th scope="col" style="width: 10%" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($variants as $index => $variant)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span
                                                style="display: inline-block; width: 50px; height: 25px; background-color: {{ $variant->color }};"
                                                class="bordered rounded"></span>
                                        </td>
                                        <td>{{ $variant->size }}</td>
                                        <td class="text-danger"><b>{{ number_format($variant->price) }}đ</b></td>
                                        <td>{{ $variant->quantity }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('product-variant.edit', [$product->id, $variant->id], ) }}"
                                                    class="btn text-primary ms-2" title="Sửa"><i class="fas fa-pen"></i></a>
                                            @if ($variant->quantity <= 0)
                                                <form action="{{ route('product-variant.delete', $variant->id) }}" method="post"
                                                    class="ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn text-danger"
                                                        onclick="return confirm('Bạn có muốn xóa biến thể này.')"><i
                                                            class="fas fa-trash-alt"></i></button>
                                                </form>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $variants->links() }}
                    @else
                        <h2>Không có biến thể nào.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script> const productId = {{ $product->id }} </script>
    @vite('resources/js/product-variant.js')
@endsection