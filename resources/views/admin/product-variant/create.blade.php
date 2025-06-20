@extends('admin.layout.master')

@section('title')
    Tạo mới biến thể - {{ $product->name }}
@endsection

@section('content')
    <div class="bg-light rounded h-100 p-4">
        <h6 class="mb-4">Tạo biến thể - {{ $product->name }}</h6>
        <div id="variant-form">
            <form id="form-variant" action="{{ route('product-variant.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div>
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </div>
                        <div>
                            <label for="" class="form-label">Giá</label>
                            <input type="number" min="0" step="0.1" class="form-control" name="price">
                            <span class="text-danger error-price"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Số lượng</label>
                            <input min="1" step="1" type="number" class="form-control" name="quantity">
                            <span class="text-danger error-quantity"></span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <label for="" class="form-label">Kích cỡ</label>
                            <input min="35" max="50" step="1" type="number" class="form-control" name="size">
                            <span class="text-danger error-size"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Màu sắc</label>
                            <div>
                                <input type="color" class="form-control-color" name="color">
                            </div>
                            <span class="text-danger error-color"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('product-variant.index', $product->id) }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-2"></i>Danh sách</a>
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save me-2"></i>Lưu</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#form-variant").on("submit", function (e) {
                e.preventDefault();

                $(".text-danger").text("");
                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        console.log(response);
                        if (response.status === "success") {
                            // $("input[name='price']").val("");
                            // $("input[name='quantity']").val("");
                            // $("input[name='size']").val("");
                            // $("input[name='color']").val("");

                            toastr.success(response.message);

                        }
                    }, error: function (xhr) {
                        console.error(xhr.responseText);

                        $(".error-name").text("");
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.quantity) {
                                $(".error-quantity").text(errors.quantity[0]);
                            }
                            if (errors.price) {
                                $(".error-price").text(errors.price[0]);
                            }
                            if (errors.size) {
                                $(".error-size").text(errors.size[0]);
                            }
                            if (errors.color) {
                                $(".error-color").text(errors.color[0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection