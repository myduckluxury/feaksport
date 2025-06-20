@extends('admin.layout.master')

@section('title')
    Cập nhật thương hiệu
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-voucher" class="bg-light rounded p-4">
                <form action="{{ route('admin-voucher.update', $voucher->id) }}" id="voucher-form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" name="name" disabled class="form-control mb-2" value="{{ $voucher->id }}">
                    </div>
                    <div>
                        <label class="form-label">Tên khuyến mãi</label>
                        <input type="text" name="name" class="form-control mb-2" value="{{ $voucher->name }}">
                        <span class="text-danger error-name"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Mã khuyến mãi</label>
                        <input type="text" name="code" value="{{ $voucher->code }}" class="form-control mb-2">
                        <span class="text-danger error-code"></span>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Kiểu giá trị</label>
                        <select name="type" id="type" class="form-select mb-2">
                            <option value="percentage" {{ $voucher->type == 'percentage' ? 'selected' : '' }}>Giảm giá theo phần trăm</option>
                            <option value="fixed" {{ $voucher->type == 'fixed' ? 'selected' : '' }}>Giảm giá theo số tiền</option>
                        </select>
                        <span class="text-danger error-type"></span>
                    </div>
                    <div class="mt-3">
                        <label for="" class="form-label">Loại khuyến mại</label>
                        <select name="kind" id="kind" class="form-select mb-2">
                            <option value="shipping" {{ $voucher->kind == 'shipping' ? 'selected' : '' }}>Phí vận chuyển</option>
                            <option value="total" {{ $voucher->kind == 'total' ? 'selected' : '' }}>Giảm giá đơn hàng</option>
                        </select>
                        <span class="text-danger error-kind"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giá trị khuyến mãi</label>
                        <input type="number" step="0.1" id="value" name="value" value="{{ $voucher->value }}" class="form-control mb-2">
                        <span class="text-danger error-value"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giá trị tối thiểu áp dụng</label>
                        <input type="number" step="0.1" name="min_total" value="{{ $voucher->min_total }}" class="form-control mb-2">
                        <span class="text-danger error-min-total"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Giảm giá tối đa</label>
                        <input type="number" id="max_discount" step="0.1"  value="{{ $voucher->max_discount }}" name="max_discount" class="form-control mb-2">
                        <span class="text-danger error-max-discount"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Số lượng</label>
                        <input type="number" name="quantity" value="{{ $voucher->quantity }}" class="form-control mb-2">
                        <span class="text-danger error-quantity"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" name="start_date" value="{{ $voucher->start_date }}" class="form-control mb-2">
                        <span class="text-danger error-start_date"></span>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ngày hết hạn</label>
                        <input type="date" name="expiration_date" value="{{ $voucher->expiration_date }}" class="form-control mb-2">
                        <span class="text-danger error-expiration_date"></span>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin-voucher.index') }}" class="btn btn-sm btn-secondary"><i
                                class="fas fa-arrow-left"></i> Danh sách</a>
                        <button class="btn btn-primary btn-sm" type="submit"><i class="fas fa-save me-2"></i>Cập
                            nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#voucher-form").on("submit", function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = form.serialize() + "&_method=PUT";

                $.ajax({
                    type: "POST",
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            toastr.success(response.message);

                            setTimeout(() => {
                                window.location.href = "{{ route('admin-voucher.index') }}";
                            }, 2000);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) $(".error-name").text(errors.name[0]);
                            if (errors.code) $(".error-code").text(errors.code[0]);
                            if (errors.type) $(".error-type").text(errors.type[0]);
                            if (errors.value) $(".error-value").text(errors.value[0]);
                            if (errors.min_total) $(".error-min-total").text(errors.min_total[0]);
                            if (errors.max_discount) $(".error-max-discount").text(errors.max_discount[0]);
                            if (errors.kind) $(".error-kind").text(errors.kind[0]);
                            if (errors.quantity) $(".error-quantity").text(errors.quantity[0]);
                            if (errors.start_date) $(".error-start_date").text(errors.start_date[0]);
                            if (errors.expiration_date) $(".error-expiration_date").text(errors.expiration_date[0]);
                        }
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('administrator/js/voucher.js')  }}"></script>
@endsection