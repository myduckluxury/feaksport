@extends('client.layout.master')

@section('title')
    Đổi mật khẩu
@endsection

@section('content')
    <div class="mt-5 mb-5">
        <div class="row">
            <div id="form-change-pass" class="col-sm-8 m-auto">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
                <div class="section-title text-center">
                    <h2 class=" text-uppercase">Đổi mật khẩu</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="login-form-content">
                    <form id="change-pass-form" action="{{ route('update-password', Auth::user()->id) }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mật khẩu cũ <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="password">
                                    <span class="text-danger error-password"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Mật khẩu mới <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="new_password">
                                    <span class="text-danger error-new-password"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nhập lại mật khẩu mới <span class="required">*</span></label>
                                    <input class="form-control" type="password" name="confirm_new_password">
                                    <span class="text-danger error-confirm-new-password"></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn-login" type="submit">Cập nhật</button>
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
            $("#change-pass-form").on("submit", function(e) {
                e.preventDefault();

                $(".text-danger").text("");
                
                let form = $(this);
                let formData = form.serialize();

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("input[name='password']").val("");
                            $("input[name='new_password']").val("");
                            $("input[name='confirm_new_password']").val("");
                            toastr.success(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.password) {
                                $(".error-password").text(errors.password[0]);
                            }
                            if (errors.new_password) {
                                $(".error-new-password").text(errors.new_password[0]);
                            }
                            if (errors.confirm_new_password) {
                                $(".error-confirm-new-password").text(errors.confirm_new_password[0]);
                            }
                        }

                        if (xhr.responseJSON && xhr.responseJSON.status === "error") {
                            toastr.error(xhr.responseJSON.message);
                        }
                    }
                })
            });
        });
    </script>
@endsection
