@extends('admin.layout.master')

@section('title')
    Cập nhật hồ sơ
@endsection

@section('content')
    <div>
        <div class="bg-light rounded p-4 vh-100">
            <div class="mt-3">
                <h4>Cập nhật hồ sơ</h4>
            </div>
            <div class="mt-4 bg-white p-4 rounded">
                <form action="{{ route('admin-profile.update', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-6">
                            <div>
                                <label for="" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}" required placeholder="Nhập họ tên">
                                <span class="text-danger error-name mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Tỉnh/ Thành phố</label>
                                <select id="province" class="form-select" name="province_code" required>
                                    <option value="">-- Chọn tỉnh --</option>
                                </select>
                                <span class="text-danger error-province mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" value="{{ $address }}" required placeholder="Nhập số nhà, tên đường, phường/xã">
                                @error('address')
                                     <span class="text-danger error-name">{{ $message }}</span>
                                @enderror
                                <span class="text-danger error-address mt-3"></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="">
                                <label for="" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone_number"
                                    value="{{ $user->phone_number }}" required placeholder="Nhập số điện thoại">
                                <span class="text-danger error-phone_number mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Quận/ Huyện</label>
                                <select id="district" class="form-select" name="district" required>
                                    <option value="">-- Chọn quận/huyện --</option>
                                </select>
                                <span class="text-danger error-district mt-3"></span>
                            </div>
                            <div class="mt-3">
                                <label for="" class="form-label">Ảnh</label>
                                <input type="file" class="form-control" name="avatar">
                                <span class="text-danger error-avatar mt-3"></span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin-profile.index',$user->id) }}" class="btn btn-secondary"><i class="fas fa-address-card me-2"></i>Hồ sơ</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Lưu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const redirectUrl = `{{ route('admin-profile.index', $user->id) }}`;
    </script>
    
    <script src="{{ asset('administrator/js/profile.js') }}"></script>
@endsection