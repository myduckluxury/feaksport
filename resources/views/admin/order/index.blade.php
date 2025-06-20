@extends('admin.layout.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Danh sách đơn hàng</h6>
                <div class="row mb-3 justify-content-between">
                    <div class="col-md-4 col-sm-3">
                        <form class="d-none d-md-flex ms-4" action="{{ route('admin-order.index') }}" method="get">
                            <div class="input-group input-group-sm">
                                <input class="form-control" name="keyword" type="text"
                                    placeholder="Tìm kiếm đơn hàng theo mã" value="{{ request('keyword') }}">
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
                                        <option value="unconfirmed" {{ request('status') == 'unconfirmed' ? 'selected' : '' }}>Chưa xác nhận</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã
                                            xác nhận</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            Hoàn thành</option>
                                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Đơn
                                            đã hủy</option>
                                        <option value="returned" {{ request('status') == 'returned' ||  request('status') == 'returning' ? 'selected' : '' }}>Đơn
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
                                    <th>Thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng tiền</th>
                                    <th>Ngày tạo</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <th>{{ $order->order_code }}</th>
                                        <td class="text-start text-nowrap" style="width:1px">
                                            <ul>
                                                <li>{{ $order->fullname }}</li>
                                                <li>{{ $order->phone_number }}</li>
                                                <li>{{ $order->email }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <div>
                                                <span>{{ $payment_method[$order->payment_method] }}</span>
                                            </div>
                                            <div>
                                                <small
                                                    class="{{$payment_status[$order->payment_status]['class']}} fw-bold">{{ $payment_status[$order->payment_status]['value']}}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <span
                                                class="fw-bold {{ $status[$order->status]['class'] }}">{{ $status[$order->status]['value'] }}</span>
                                        </td>
                                        <td>
                                            <span
                                                class="text-dark fw-bold">{{ number_format($order->total_final, 0, '.', '.') }}đ</span>
                                        </td>
                                        <td class="text-start">
                                            {{ $order->created_at->format('d \t\h\g m, Y') }}
                                        </td>
                                        <td class="text-nowrap" style="width:1px">
                                            <a href="{{ route('admin-order.detail', $order->id) }}" class="btn text-primary"><i
                                                    class="fas fa-pen"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
        @vite('resources/js/order/list.js')
@endsection