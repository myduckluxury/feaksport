@extends('admin.layout.master')

@section('title')
    Đổi mật khẩu
@endsection

@section('content')
    <div>
        <div class="bg-light rounded p-4 vh-100">
            <div class="mt-3">
                <h4>Đổi mật khẩu</h4>
            </div>
            <div class="mt-4">
                <div class="row bg-white pt-4 pb-4">
                    <div class="col-md-4 text-center border-end">
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('administrator/img/user.jpg') }}"
                            width="150" class="profile-image mb-3 rounded-circle border" alt="Profile Photo">
                        <h5 class="mb-1">{{$user->name }}</h5>
                        <p class="text-muted">{{$user->email }}</p>
                    </div>
                    <div class="col-md-8">
                        <form id="form-change-password" action="{{ route('admin-profile.update-password', $user->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="">
                                <label for="">Email</label>
                                <input type="email" class="form-control form-control-sm" name="email"
                                    placeholder="Nhập email của bạn">
                                <span class="text-danger error-email mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="">Mật khẩu cũ</label>
                                <input type="password" class="form-control form-control-sm" name="old_password"
                                    placeholder="Nhập mật khẩu cũ">
                                <span class="text-danger error-old_password mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="">Mật khẩu mới</label>
                                <input type="password" class="form-control form-control-sm" name="password"
                                    placeholder="Nhập mật khẩu mới">
                                <span class="text-danger error-password mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="">Nhập lại mật khẩu mới</label>
                                <input type="password" class="form-control form-control-sm" name="confirm_password"
                                    placeholder="Nhập lại mật khẩu mới">
                                <span class="text-danger error-confirm_password mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('dashboard.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-2"></i>Quay lại</a>
                                <button type="submit" class="btn btn-sm btn-primary"><i
                                        class="fas fa-save me-2"></i>Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#form-change-password').on('submit', function (e) {
            e.preventDefault();

            $('.text-danger').text('');

            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(),
                success: function (response) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                        form[0].reset();
                        
                        setTimeout(() => {
                            window.location.href = "{{ route('admin-profile.index', $user->id) }}";
                        }, 1500);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            $(`.error-${key}`).text(value[0]);
                        });
                    } else if (xhr.status === 500) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });
    </script>
@endsection