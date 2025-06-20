@extends('auth.layout.master')

@section('content')
    <div id="form-signup" class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-around mb-3">
            <a href="{{ route('home') }}" class="pt-1">
                <img src="{{ asset('client/img/logo1.webp') }}" width="150" alt="">
            </a>
            <h4 class="pt-3 text-primary">Đăng ký</h4>
        </div>
        <form id="signup-form" action="{{ route('signup.signup') }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control">
                <label for="floatingText">Email</label>
                <div class="mt-2">
                    <span class="text-danger error-email"></span>
                </div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" name="name" class="form-control" id="floatingInput">
                <label for="floatingInput">Họ tên</label>
                <div class="mt-2">
                    <span class="text-danger error-name"></span>
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control">
                <label for="floatingPassword">Mật khẩu</label>
                <div class="mt-2">
                    <span class="text-danger error-password"></span>
                </div>
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="confirm_password" class="form-control">
                <label for="floatingPassword">Nhập lại mật khẩu</label>
                <div class="mt-2">
                    <span class="text-danger error-confirm_password"></span>
                </div>
            </div>
            <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Đăng ký</button>
            <p class="text-center mb-0">Bạn đã có tài khoản? <a href="{{ route('signin') }}">Đăng nhập</a></p>
            <div class="d-flex justify-content-center align-items-center">
                <p class="text-center me-2 mt-3">Hoặc đăng ký bằng </p>
                <a href="{{ route('auth.google') }}" class="btn btn-outline-primary "><i
                        class="fab fa-google fa-lg me-2"></i><strong>Google</strong></a>
            </div>
        </form>
    </div>

    {{-- Validate ajax --}}
    <script>
        $(document).ready(function () {
            $("#signup-form").on("submit", function (e) {
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
                        if (response.status === "success") {
                            toastr.success(response.message);

                            setTimeout(() => {
                                window.location.href = "{{ route('signin') }}";
                            }, 3000);;
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);

                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.email) {
                                $(".error-email").text(errors.email[0]);
                            }
                            if (errors.name) {
                                $(".error-name").text(errors.name[0]);
                            }
                            if (errors.password) {
                                $(".error-password").text(errors.password[0]);
                            }
                            if (errors.confirm_password) {
                                $(".error-confirm_password").text(errors.confirm_password[0]);
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