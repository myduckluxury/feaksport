@extends('auth.layout.master')

@section('title')
    Quên mật khẩu
@endsection

@section('content')
    <div id="form-signin" class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <a href="{{ route('home') }}" class="pt-1">
                <img src="{{ asset('client/img/logo1.webp') }}" width="120" alt="">
            </a>
            <h4 class="pt-3 text-primary">Quên mật khẩu</h4>
        </div>
        <form id="signin-form" action="{{ route('forgot-password.forgot') }}" method="post">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="floatingInput">
                <label for="floatingInput">Nhập email của bạn</label>
                @error('email')
                    <div class="mt-2">
                        <span class="text-danger error-email">{{ $message }}</span>
                    </div>
                @enderror
            </div>
            <div class="mb-4">
                <a href="{{ route('signin') }}">Quay về trang đăng nhập</a>
            </div>
            <button type="submit" class="btn btn-primary py-3 w-100 mb-4 text-uppercase">Gửi</button>
        </form>
    </div>
@endsection
