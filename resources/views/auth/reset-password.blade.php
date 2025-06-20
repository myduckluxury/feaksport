@extends('auth.layout.master')

@section('title')
    Quên mật khẩu
@endsection

@section('content')
    <div id="form-signin" class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-center mb-3">
            <h4 class="pt-3 text-primary">Đặt lại mật khẩu</h4>
        </div>
        <form id="signin-form" action="{{ route('forgot-password.reset', $token) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-floating mb-4">
                <input type="password" name="password" class="form-control">
                <label for="floatingPassword">Mật khẩu</label>
                @error('password')
                    <div class="mt-2">
                        <span class="text-danger error-password">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="form-floating mb-4">
                <input type="password" name="confirm_password" class="form-control">
                <label for="floatingPassword">Nhập lại mật khẩu</label>
                @error('confirm_password')
                    <div class="mt-2">
                        <span class="text-danger error-confirm_password">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="mb-4">
                <a href="{{ route('signin') }}">Quay về trang đăng nhập</a>
            </div>
            <button type="submit" class="btn btn-primary py-3 w-100 mb-4 text-uppercase">Gửi</button>
        </form>
        <div class="mb-4">
            <a href="{{ route('home') }}">Quay về trang chủ</a>
        </div>
    </div>
@endsection
