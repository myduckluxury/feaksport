@extends('client.layout.master')

@section('title')
    Thông tin tài khoản
@endsection

@section('content')
    <div class="row justify-content-center mt-5 mb-3">
        <div class="col-6">
            <h2 class="text-uppercase text-center">Thông tin chi tiết</h2>
            <table class="table">
                <tr>
                    <th class="text-center" colspan="2">Avatar</th>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">
                        <img width="130" class="rounded border shadow" src="{{ Auth::user()->avatar ? Storage::url(Auth::user()->avatar) :  asset('administrator/img/user.jpg') }}" alt="">
                    </td>
                </tr>
                <tr>
                    <th>Họ tên:</th>
                    <td>{{ Auth::user()->name }}</td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td>{{ Auth::user()->email }}</td>
                </tr>
                <tr>
                    <th>Số điện thoại:</th>
                    @if (Auth::user()->phone_number != null)
                        <td>{{ Auth::user()->phone_number }}</td>
                    @else
                       <td class="d-flex"> <p>Chưa liên kết</p></td>
                      
                    @endif
                </tr>
                <tr>
                    <th>Địa chỉ:</th>
                    @if (Auth::user()->address != null)
                        <td>{{ Auth::user()->address }}</td>
                    @else
                       <td class="d-flex"> <p>Chưa có địa chỉ</p></td>
                    @endif
                </tr>
            </table>
            <div class="text-center mt-4 mb-5">
                <a href="{{ route('profile.edit')}}" class="btn-theme btn-sm">Cập nhật thông tin</a>
            </div>
        </div>
    </div>
@endsection
