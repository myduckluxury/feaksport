@extends('admin.layout.master')

@section('title')
    Tạo tài khoản nhân viên
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-brand" class="bg-light rounded vh-100 p-4">
                <div>
                    <h6>Tạo tài khoản nhân viên</h6>
                </div>
                <div class="mt-3 bg-white p-3">
                    <form id="staff-form" action="{{ route('admin-staff.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control mb-2" placeholder="Nhập email">
                            <span class="text-danger error-email"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Họ tên</label>
                            <input type="text" name="name" class="form-control mb-2" placeholder="Nhập họ tên">
                            <span class="text-danger error-name"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Mật khẩu</label>
                            <input type="password" name="password" class="form-control mb-2" placeholder="Nhập mật khẩu">
                            <span class="text-danger error-password"></span>
                        </div>
                        <div class="mt-3">
                            <label for="" class="form-label">Xác nhận mật khẩu</label>
                            <input type="password" name="confirm_password" class="form-control mb-2"
                                placeholder="Nhập lại mật khẩu">
                            <span class="text-danger error-confirm-password"></span>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin-staff.index') }}" class="btn btn-secondary btn-sm"><i
                                    class="fas fa-arrow-left me-2"></i>Danh sách</a>
                            <button type="submit" class="btn btn-primary btn-sm"><i
                                    class="fas fa-save me-2"></i>Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#staff-form').on('submit', function (e) {
            e.preventDefault();

            $('.text-danger').text('');

            $.ajax({
                url: "{{ route('admin-staff.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (res) {
                    if(res.status === 'success') {
                        toastr.success(res.message);
                        $('#staff-form')[0].reset();
                    }
                },
                error: function (err) {
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
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
                            $(".error-confirm-password").text(errors.confirm_password[0]);
                        }
                    }

                    if (err.responseJSON && err.responseJSON.status === "error") {
                        toastr.error(err.responseJSON.message);
                    }
                }
            });
        });
    </script>
@endsection