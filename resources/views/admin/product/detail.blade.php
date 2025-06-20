@extends('admin.layout.master')

@section('title')
    Chi tiết sản phẩm - {{ $product->name }}
@endsection

@section('content')
    <div class="bg-light rounded p-4">
        <div id="form-image">
        </div>
        <h6 class="mb-4">Chi tiết sản phẩm</h6>
        <div class="mb-3 text-start">
            <a href="{{ route('admin-product.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-2"></i>Danh sách</a>
            <a href="{{ route('admin-product.edit', $product->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-pen me-2"></i>Cập nhật</a>
            <a href="{{ route('product-variant.index', $product->id) }}" class="btn btn-sm btn-success"><i class="fas fa-boxes me-2"></i>Biến thể</a>
        </div>
        <div class="row">
            <div class="table-reponsive bg-white">
                <table class="table mt-3">
                    <tr>
                        <th colspan="2" class="text-center">
                            Ảnh
                        </th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="row">
                                @foreach ($images as $item)
                                    <div class="col-4 mb-3">
                                        <div class="position-relative">
                                            <img src="{{ Storage::url($item->image_url) }}" width="200" alt=""
                                                class="img-fluid">
                                            <form id="delete-image" action="{{ route('admin-image.delete', $item->id) }}"
                                                method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn text-secondary btn-sm position-absolute top-0 start-100 translate-middle">
                                                    <i class="fas fa-trash-alt fa-lg" title="Xóa ảnh"
                                                        onclick="return confirm('Bạn có muốn xóa ảnh này không?')"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                <form id="image-form" action="{{ route('admin-image.create') }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-4 mb-3">
                                        <label for="uploadImage"
                                            class="btn btn-outline-primary d-flex flex-column align-items-center py-3 mb-2">
                                            <i class="fas fa-upload"></i>
                                            <span>Tải ảnh lên</span>
                                        </label>
                                        <span class="text-danger error-image-url mt-2"></span>
                                        <input multiple hidden type="file" name="image_url[]" id="uploadImage"
                                            class="custom-file-input form-control">
                                        <input type="text" name="product_id" value="{{ $product->id }}" hidden>
                                    </div>
                                    <div>
                                        <button class="btn btn-primary btn-sm" type="submit"><i
                                                class="fas fa-save me-2"></i>Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th>Mã sản phẩm</th>
                        <td>{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Danh mục
                        <td>{{ $product->category->name }}</td>
                    </tr>
                    <tr>
                        <th>Thương hiệu</th>
                        <td>{{ $product->brand->name }}</td>
                    </tr>
                    <tr>
                        <th>Ngày tạo</th>
                        <td>{{ $product->created_at->format('d \T\h\á\n\g m, Y') }}</td>
                    </tr>
                    <tr>
                        <th>Giảm giá</th>
                        <td>{{ $product->discount }} %</td>
                    </tr>
                    <tr>
                        <th>Sản phẩm nổi bật</th>
                        <td>{{ $product->featured == 0 ? 'Không' : 'Có'}}</td>
                    </tr>
                    <tr>
                        <th>Số lượng tồn kho</th>
                        <td>{{ $product->variants->sum('quantity') }}</td>
                    </tr>
                    <tr>
                        <th>Số lượt bán</th>
                        <td>{{ $product->sales_count }}</td>
                    </tr>
                    <tr>
                        <th colspan="2" class="text-center">Mô tả</th>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-5">{!! $product->description !!}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        const productId = {{ $product->id }};
        document.getElementById("uploadImage").addEventListener("change", function () {
            let fileCount = this.files.length;
            let displayText = fileCount > 0 ? fileCount + " tệp" : "Chọn ảnh";

            document.querySelector("label[for='uploadImage'] span").textContent = displayText;
        });

    </script>

    <script>
        $(document).ready(function () {
            $("#image-form").on("submit", function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: $(this).attr("action"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                           toastr.success(response.message);
                            $(".error-image-url").text("");
                            setTimeout(() => location.reload(), 2000);
                        }
                    },
                    error: function (xhr) {
                        $(".error-image-url").text("");

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            Object.keys(errors).forEach(key => {
                                $(".error-image-url").append(errors[key][0] + "<br>");
                            });
                        }
                    }
                });
            });
        });
    </script>
    @vite('resources/js/product/detail.js')
@endsection