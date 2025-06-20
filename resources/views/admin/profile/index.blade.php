@extends('admin.layout.master')

@section('title')
    Thông tin cá nhân
@endsection

@section('content')
    <div>
        <div class="bg-light rounded p-4 vh-100">
            <div class="mt-3">
                <h4>Hồ sơ</h4>
            </div>
            <div class="mt-4">
                <div class="row bg-white pt-4 pb-4">
                    <div class="col-md-4 text-center border-end">
                        <img src="{{ $user->avatar ? Storage::url($user->avatar) : asset('administrator/img/user.jpg') }}" width="150"
                            class="profile-image mb-3 rounded-circle border" alt="Profile Photo">
                        <h5 class="mb-1">{{$user->name }}</h5>
                        <p class="text-muted">{{$user->email }}</p>
                        <a href="{{ route('admin-profile.edit', $user->id) }}" class="btn btn-primary">Chỉnh sửa</a>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Họ tên:</strong>
                                <p>{{$user->name }}</p>
                            </div>
                            <div class="col-sm-6">
                                <strong>Số điện thoại:</strong>
                                <p>{{$user->phone_number ?? 'Chưa có' }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Email:</strong>
                                <p>{{$user->email }}</p>
                            </div>
                            <div class="col-sm-6">
                                <strong>Chức vụ:</strong>
                                <p>{{ $role[$user->role] }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <strong>Địa chỉ:</strong>
                                <p>{{ $address ?? 'Chưa có' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <strong>Quận/ Huyện:</strong>
                                <p>{{ $district ?? 'Chưa có' }}</p>
                            </div>
                            <div class="col-sm-6">
                                <strong>Tỉnh/ Thành phố:</strong>
                                <p>{{ $province ?? 'Chưa có' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection