@extends('admin/layout/master')

@section('title')
    Người dùng
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bg-light rounded min vh-100 p-4">
                <div class="">
                    <div class="d-flex align-items-center">
                        <h6 class="title">Danh sách khách hàng</h6>
                        </a>
                    </div>
                    <div class="row mt-3">
                        <div class="col-4">
                            <form method="GET" action="{{ route('admin.user') }}">
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
                            <form action="{{ route('admin.user') }}" method="get">
                                <div class="d-flex align-items-center justify-content-end">
                                    <div class=" me-2">
                                        <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                                        <select name="status" id="" class="form-select form-select-sm">
                                            <option value="all">Tất cả</option>
                                            <option value="unconfirmed"
                                                {{ request('status') == 'unconfirmed' ? 'selected' : '' }}>Chưa xác nhận
                                            </option>
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

                </div>
                <div class=" table-responsive bg-white ps-3 pe-3 mt-3">
                    <table class="table mt-4 table-striped">
                        <thead>
                            <tr class="text-center">
                                <th>STT</th>
                                <th>Họ tên</th>
                                <th>EMAIL</th>
                                <th>Chức năng</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr class="text-center">
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        {{ $role[$user->role] }}
                                    </td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <span
                                                class="{{ $status[$user->status]['class'] }} fw-bold">{{ $status[$user->status]['value'] }}</span>
                                        @else
                                            <span class="text-primary fw-bold">Chưa xác nhận</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('d \T\h\á\n\g m, Y') }}
                                    </td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn text-primary" title="Edit"
                                                data-bs-toggle="modal" data-bs-target="#exampleModal{{ $index }}">
                                                <i class="fa fa-pen"></i>
                                            </button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <form action="{{ route('admin.user.edit', $user) }}" method="POST"
                                                    class="modal-dialog">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Chỉnh sửa
                                                                quền truy cập
                                                            </h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body d-flex">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    value="1" @checked($user->status == 1)
                                                                    name="status"
                                                                    @if ($user->status == 1) disabled @endif
                                                                    id="flexRadioDefault1{{ $index }}">
                                                                <label class="form-check-label fw-bold"
                                                                    for="flexRadioDefault1{{ $index }}">
                                                                    Hoạt động
                                                                </label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio"
                                                                    name="status"
                                                                    @if ($user->status == 0) disabled @endif
                                                                    id="flexRadioDefault2{{ $index }}"
                                                                    value="0" @checked($user->status == 0)>
                                                                <label class="form-check-label text-danger fw-bold"
                                                                    for="flexRadioDefault2{{ $index }}">
                                                                    Khóa
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('admin.user.verify', $user->id) }}" method="post">@csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    onclick="return confirm('Bạn có muốn xác nhận tài khoản này!')"
                                                    class="btn text-primary btn-sm"><i
                                                        class="fas fa-lg fa-check"></i></button></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/user.js')
@endsection
