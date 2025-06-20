@extends('client.layout.master')

@section('title')
    Cập nhật thông tin
@endsection

@section('content')
    <div class="mt-5 mb-5">
        <div class="row">
            <div class="col-sm-8 m-auto"  id="form-profile">
                <div class="section-title text-center">
                    <h2 class=" text-uppercase">Cập nhật thông tin</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="register-form-content">
                    <form id="profile-form" action="{{ route('profile.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Họ tên <span class="required">*</span></label>
                                    <input class="form-control" type="text" value="{{ Auth::user()->name }}"
                                        name="name" placeholder="Nhập họ tên.">
                                    <span class="text-danger error-name"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Số điện thoại <span class="required">*</span></label>
                                    <input class="form-control" type="tel" name="phone_number"
                                        placeholder="Nhập số điện thoại." value="{{ Auth::user()->phone_number }}">
                                    <span class="text-danger error-phone-number"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Avatar</label>
                                    <input class="form-control" type="file" name="avatar">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Địa chỉ <span class="required">*</span></label>
                                    <input class="form-control" type="text" name="address"
                                        placeholder="Nhập địa chỉ." value="{{ Auth::user()->address }}">
                                    <span class="text-danger error-address"></span>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb--0">
                                    <button type="submit" class="btn-register">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#profile-form").on("submit", function(e) {
                e.preventDefault();

                $(".text-danger").text("");

                let form = $(this);
                let formData = new FormData(this);

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            toastr.success(response.message);

                            setTimeout(() => {
                                window.location.href = "{{ route('profile') }}";
                            }, 2000);;
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $(".error-name").text(errors.name[0]);
                            }
                            if (errors.phone_number) {
                                $(".error-phone-number").text(errors.phone_number[0]);
                            }
                            if (errors.address) {
                                $(".error-address").text(errors
                                    .address[0]);
                            }
                        }
                        if (xhr.responseJSON.status === "error") {
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                })
            });
        });
    </script>
@endsection
