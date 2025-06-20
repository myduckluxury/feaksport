@extends('admin.layout.master')

@section('title')
    Yêu cầu hoàn trả
@endsection

@section('content')
    <div class="col-12">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Danh sách đơn hàng</h6>
            <div class="row mb-3 justify-content-between">
                <div class="col-md-4 col-sm-3">
                    <form class="d-none d-md-flex ms-4" action="{{ route('admin-order.index') }}" method="get">
                        <div class="input-group input-group-sm">
                            <input class="form-control" name="keyword" type="text" placeholder="Tìm kiếm đơn hàng theo mã"
                                value="{{ request('keyword') }}">
                            <button type="submit" class="input-group-text bg-primary text-light"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-sm-3">
                    <form action="{{ route('admin-order.index') }}" method="get">
                        <div class="d-flex align-items-center">
                            <div class="w-75 me-2">
                                <select name="status" id="" class="form-select form-select-sm">
                                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>Tất cả</option>
                                    <option value="unconfirmed" {{ request('status') == 'unconfirmed' ? 'selected' : '' }}>
                                        Chưa xác nhận</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã
                                        xác nhận</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Hoàn thành</option>
                                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Đơn
                                        đã hủy</option>
                                    <option value="returned" {{ request('status') == 'returned' || request('status') == 'returning' ? 'selected' : '' }}>Đơn
                                        hoàn trả</option>
                                </select>
                            </div>
                            <button class="btn btn-sm btn-primary"><i class="fas fa-filter"></i> Lọc</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white p-3">
                <div class="table-responsive">
                    <table class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th class="text-nowrap" style="width:1px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($return as $index => $item)
                                <tr>
                                    <th>
                                        <a href="{{ route('admin-order.detail', $item->order_id) }}"> 
                                            {{ $item->order->order_code }}
                                        </a>
                                    </th>
                                    <td>
                                        <span>{{ $item->fullname }}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold">{{ number_format($item->order->total_final, 0, '.', '.') }}đ</span>
                                    </td>
                                    <td>
                                        <span class="{{ $status[$item->status]['class'] }} fw-bold">{{ $status[$item->status]['value']}}</span>
                                    </td>
                                    <td>
                                        {{ $item->created_at->format('d \t\h\g m, Y') }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin-return.detail', $item->id) }}" class="btn text-primary"><i
                                                class="fas fa-pen"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $return->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection