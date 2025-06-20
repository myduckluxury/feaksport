@extends('admin.layout.master')

@section('title')
    Thêm mới sản phẩm
@endsection

@section('content')
    <div class="bg-light rounded h-100 p-4">
        <div id="form-product">
            <form id="product-form" action="{{ route('admin-product.store') }}" method="post">
                @csrf
                <div class="row g-4">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label">Mã sản phẩm</label>
                            <input type="text" name="sku" class="form-control">
                            <span class="text-danger error-sku mt-2"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control">
                            <span class="text-danger error-name mt-2"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Giảm giá</label>
                            <input  name="discount" class="form-control" min="0" step="0.1" value="0">
                            <span class="text-danger error-discount mt-2"></span>

                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="" class="form-label">Danh mục</label>
                            <select class="form-select" name="category_id" id="">
                                <option value="" selected disabled>Chọn danh mục</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-category mt-2"></span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Thương hiệu</label>
                            <select class="form-select" name="brand_id" id="">
                                <option value="" disabled selected>Chọn thương hiệu</option>
                                @foreach ($brands as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-brand mt-2"></span>
                        </div>
                        <div class="mb-3 mt-5 form-check">
                            <label class="form-check-label" for="">Sản phẩm nổi bật</label>
                            <input type="checkbox" name="featured" value="1" class="form-check-input">
                        </div>
                    </div>
                    <div class="col-12">
                        <div>
                            <label for="" class="form-label">Mô tả</label>
                        </div>
                        <span class="text-danger error-description mt-2"></span>
                        <div class="mb-3">
                            <textarea class="form-control" name="description" id="description" cols="30"
                                rows="10"></textarea>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('admin-product.index') }}" class="btn btn-secondary"><i
                                class="fas fa-arrow-left me-2"></i>Danh sách</a>
                        <button class="btn btn-primary" type="submit"><i class="fas fa-save me-2"></i>Lưu</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- CKEditorCKEditor --}}
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('description', {
            entities: false,
            basicEntities: false,
            entities_latin: false,
            entities_greek: false
        });
    </script>

    <script>
        $(document).ready(function () {
            $("#product-form").on("submit", function (e) {
                e.preventDefault();

                if (typeof CKEDITOR !== "undefined") {
                    for (let instance in CKEDITOR.instances) {
                        if (CKEDITOR.instances.hasOwnProperty(instance)) {
                            CKEDITOR.instances[instance].updateElement();
                        }
                    }
                }

                $(".text-danger").text("");

                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            $("input[name='sku']").val("");
                            $("input[name='name']").val("");
                            $("input[name='discount']").val("");
                            $("select[name='category_id']").val("");
                            $("select[name='brand_id']").val("");
                            $("input[name='featured']").prop("checked", false);
                            CKEDITOR.instances.description.setData("");
                            toastr.success(response.message);

                            setTimeout(function () {
                                window.location.href = '/admin/product/detail/' + response.data;
                            }, 1500);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;

                            if (errors.sku) {
                                $(".error-sku").text(errors.sku[0]);
                            }

                            if (errors.name) {
                                $(".error-name").text(errors.name[0]);
                            }

                            if (errors.description) {
                                $(".error-description").text(errors.description[0]);
                            }

                            if (errors.category_id) {
                                $(".error-category").text(errors.category_id[0]);
                            }

                            if (errors.brand_id) {
                                $(".error-brand").text(errors.brand_id[0]);
                            }

                            if (errors.discount) {
                                $(".error-discount").text(errors.discount[0]);
                            }
                        }
                    }
                });
            });
        });

    </script>
@endsection