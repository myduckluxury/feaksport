@extends('admin/layout/master')

@section('title')
    Nhân viên
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-light rounded min vh-100 p-4">
                <div class="">
                    <div class="d-flex align-items-center">
                        <h6 class="title">Danh sách nhân viên</h6>
                        </a>
                    </div>
                </div>

                <div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <form method="GET" action="{{ route('admin-staff.index') }}">
                                <div class="input-group input-group-sm">
                                    <input type="hidden" name="status" value="{{ request('status', 'all') }}">
                                    <input class="form-control" name="keyword" type="text"
                                        placeholder="Tìm kiếm tài khoản theo tên hoặc email" value="{{ request('keyword') }}">
                                    <button type="submit" class="input-group-text bg-primary text-light"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-8">
                            <form action="{{ route('admin-staff.index') }}" method="get">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class=" me-2">
                                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                                        <select name="status" id="" class="form-select form-select-sm">
                                            <option value="all">Tất cả</option>
                                            <option value="banned"
                                                {{ request('status') == 'banned' ? 'selected' : '' }}>Vô hiệu hóa
                                            </option>
                                            <option value="active"
                                                {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động
                                            </option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin-staff.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus me-2"></i>Tạo mới</a>
                    </div>

                    <div class=" table-responsive bg-white ps-3 pe-3 mt-3">
                        <table class="table mt-4 table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($staffs as $index => $staff)
                                    <tr class="text-center">
                                        <th>{{ $index + 1 }}</th>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            <span
                                                class=" fw-bold {{ $status[$staff->status]['class'] }}">{{ $status[$staff->status]['value'] }}</span>
                                        </td>
                                        <td>
                                            {{ $staff->created_at->format('d \T\h\á\n\g m, Y') }}
                                        </td>
                                        <td>
                                            <form action="{{ route('admin-staff.status', $staff->id) }}" method="post">
                                                @csrf
                                                @method('PATCH')
                                                @if ($staff->status == 1)
                                                    <button class="btn text-danger" name="action" value="ban"
                                                        type="submit"
                                                        onclick="return confirm('Bạn có muốn khóa tài khoản nây.')"><i
                                                            class="fas fa-ban"></i></button>
                                                @else
                                                    <button class="btn text-primary" name="action" value="unban"
                                                        type="submit"
                                                        onclick="return confirm('Bạn có muốn mở khóa tài khoản nây.')"><i
                                                            class="fas fa-unlock-alt"></i></button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $staffs->links() }} 
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/user.js')
    @endsection
