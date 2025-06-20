@extends('admin.layout.master')

@section('title')
    Thông tin hoàn trả
@endsection

@section('content')
    <div class="bg-light mt-3 p-3">
        <div class="d-flex justify-content-between">
            @if ($reason->status == 'pending')
                <form class="return-order" action="{{ route('admin-order.return-confirm', $reason->order_id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <input hidden name="reason" value="{{ $reason->reason }}">
                    <button type="submit" class="btn btn-sm btn-primary"
                        onclick="return confirm('Bạn có muốn hoàn đơn hàng này.')">Xác nhận hoàn đơn</button>
                    <a data-bs-toggle="modal" data-bs-target="#cancel-return" class="btn btn-sm btn-danger">Từ chối</a>
                </form>
            @endif
            <a href="{{ route('admin-order.detail', $reason->order_id) }}" class="btn btn-secondary btn-sm">Chi tiết đơn
                hàng</a>
        </div>
        <div class="bg-white p-2 mt-3">
            <table class="table">
                <tr>
                    <th>Mã đơn hàng</th>
                    <td><a
                            href="{{ route('admin-order.detail', $reason->order_id) }}">{{ $reason->order->order_code }}</a>
                    </td>
                    <td>
                        <span class="fw-bold">Ngày tạo: </span>{{ $reason->created_at->format('d \t\h\á\n\g m, Y') }}
                    </td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td class="fw-bold {{ $status[$reason->status]['class'] }}">{{ $status[$reason->status]['value'] }}</td>
                    <td>
                        @if ($reason->status == 'rejected')
                            <span><strong>Lý do từ chối:</strong> {{ $reason->admin_note }}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Lý do</th>
                    <td colspan="2">
                        <p>{{ $reason->reason }}</p>
                    </td>
                </tr>
                <tr>
                    <th>Hình ảnh sản phẩm</th>
                    <td colspan="2">
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-4 mb-3">
                                    <img src="{{ Storage::url($image->image) }}" alt="" width="120" class="rounded">
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tổng giá trị đơn hàng</th>
                    <td colspan="2">
                        <span
                            class="text-danger fw-bold">{{ number_format($reason->order->total_final, 0, '.', '.') }}đ</span>
                    </td>
                </tr>
                <tr>
                    <th>Phương thức thanh toán</th>
                    <td colspan="2">
                        <span class="">{{ $payment_method[$reason->order->payment_method] }}</span>
                    </td>
                </tr>
                <tr>
                    <th colspan="3" class="text-center">Thông tin khách hàng</th>
                </tr>
                <tr>
                    <th>Họ tên</th>
                    <td>{{ $reason->fullname }}</td>
                </tr>
                <tr>
                    <th>Thông tin ngân hàng</th>
                    <td>
                        <span class="d-block">STK: {{ $reason->bank_account }}</span>
                        <span class="d-block">{{ $reason->bank }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal fade" id="reason-return">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="return-order" action="{{ route('admin-order.returned', $reason->order_id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="modal-title">Hoàn trả sản phẩm về</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <textarea name="reason" class="form-control" id="" cols="20" rows="5"
                                placeholder="Nhập lý do hoàn trả"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="return confirm('Bạn có chắc muốn hoàn đơn.')">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancel-return">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="cancel-return" action="{{ route('admin-order.cancel-return', $reason->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h6 class="modal-title">Từ chối hoàn trả</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <textarea name="reason" class="form-control" id="" cols="20" rows="5"
                                placeholder="Nhập lý do từ chối"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary"
                            onclick="return confirm('Bạn có chắc từ chối.')">Xác nhận</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('administrator/js/return-order.js') }}"></script>
@endsection