@extends('admin.layout.master')

@section('title')
    Danh sách khuyến mãi
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded min vh-100 p-4">
                <h6 class="mb-4">Danh sách khuyến mãi</h6>
                <div class="d-flex justify-content-between">
                    <div>
                        <form action="{{ route('admin-voucher.index') }}" method="get">
                            <div class="d-flex">
                                <div class="me-2 d-flex align-items-center">
                                    <div>
                                        <label for="start">Từ ngày:</label>
                                        <input type="date" class="form-control form-control-sm" name="start_date"
                                            id="start" required value="{{ request('start_date') }}">
                                    </div>
                                    <div class="ms-2">
                                        <label for="end">Đến ngày:</label>
                                        <input type="date" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }}" id="end" required>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end">
                                    <button class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="text-end d-flex align-items-end">
                        <a href="{{ route('admin-voucher.create') }}" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus me-2"></i>Tạo mới</a>
                    </div>
                </div>
                <div class="table-responsive mt-3 bg-white p-3">
                    @if ($vouchers->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên khuyến mãi</th>
                                    <th scope="col">Mã khuyến mãi</th>
                                    <th>Thể loại</th>
                                    <th scope="col">Giá trị khuyến mãi</th>
                                    <th>Số lượng mã</th>
                                    <th scope="col">Ngày bắt đầu</th>
                                    <th scope="col">Ngày kết thúc</th>



                                    <th scope="col" class="text-nowrap text-center" style="width:1px">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($vouchers as $index => $voucher)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $voucher->name }}</td>
                                        <td>{{ $voucher->code }}</td>
                                        <td>{{ $kind[$voucher->kind] }}</td>
                                        <td class="text-danger"><b>{{ number_format($voucher->value) }}@if ($voucher->type == 'percentage')
                                                    % @elseđ
                                                @endif
                                            </b></td>
                                        <td>{{ $voucher->quantity }}</td>
                                        <td>{{ Carbon\Carbon::parse($voucher->start_date)->format('d \t\h\á\n\g m, Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($voucher->expiration_date)->format('d \t\h\á\n\g m, Y') }}
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin-voucher.edit', $voucher->id) }}"
                                                    class="btn text-primary ms-2" title="Sửa"><i
                                                        class="fas fa-pen"></i></a>
                                                <form method="post"
                                                    action="{{ route('admin-voucher.delete', $voucher->id) }}"
                                                    class="ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button title="Xóa" class="btn text-danger"
                                                        onclick="return confirm('Bạn có chắc muốn xóa.')"><i
                                                            class="far fa-trash-alt"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $vouchers->links() }}
                    @else
                        <h4 class="text-center">Chưa có khuyến mãi nào.</h4 class="text-center">
                    @endif 
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/voucher.js')
@endsection
