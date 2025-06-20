@extends('client.layout.master')

@section('title')
    Checkout | Freak Sport
@endsection

@section('content')
    <div class="mt-5 mb-5 pt-5 pb-5">
        <div>
            <div class="row justify-content-center">
                <div class="rounded w-50 pt-4 pb-4" style="border: 2px dashed #198754;">
                    <h4 class="text-center text-success">Cảm ơn bạn. Đơn hàng của bạn đã được nhận.</h4>
                </div>
            </div>
        </div>
        <div class="mt-5">
            <div class="row text-center justify-content-center align-items-center">
                <div class="col-md-auto me-4">
                    <span class="text-muted">Mã đơn hàng:</span><br>
                    <strong>{{ $order->order_code }}</strong>
                </div>
                <div class="col-md-auto border-start border-secondary" style="height: 100px;"></div>
                <div class="col-md-auto me-4">
                    <span class="text-muted">Ngày:</span><br>
                    <strong>{{ $order->created_at->format('d-m-Y') }}</strong>
                </div>
                <div class="col-md-auto border-start border-secondary" style="height: 100px;"></div>
                <div class="col-md-auto me-4">
                    <span class="text-muted">Tổng cộng:</span><br>
                    <strong>{{ number_format($order->total_final, 0, '.', '.') }}đ</strong>
                </div>
                <div class="col-md-auto border-start border-secondary" style="height: 100px;"></div>
                <div class="col-md-auto">
                    <span class="text-muted">Phương thức thanh toán:</span><br>
                    <strong>{{ $payment_method[$order->payment_method] }}</strong>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="w-50">
                <h2 class="text-uppercase">Chi tiết đơn hàng</h2>
                <div class="table-reponsive">
                    <table class="table">
                        <tr class="text-uppercase">
                            <th>Sản phẩm</th>
                            <th class="text-end">Tổng</th>
                        </tr>
                        @foreach ($orderItems as $item)
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold"><a
                                                href="{{ route('product.detail', ['id' => $item->product_variant->product_id, 'slug' => Str::slug($item->product_name)]) }}">{{ $item->product_name }}</a>
                                            ×
                                            {{ $item->quantity }}</span>
                                    </div>
                                    <div>
                                        <span><strong>Size: </strong>{{ $item->size }}</span>
                                    </div>
                                    <div class="d-flex">
                                        <div>
                                            <span class="fw-bold">Màu sắc:</span>
                                        </div>
                                        <div class="rounded-circle border border-secondary shadow mt-2 ms-2"
                                            style="width: 16px; height: 16px; background-color: {{ $item->color }}; display: inline-block;">
                                        </div>
                                    </div>
                                </td>
                                <th class="text-end">
                                    <span>{{ number_format($item->unit_price, 0, '.', '.') }}đ</span>
                                </th>
                            </tr>
                        @endforeach
                        <tr>
                            <th>Shipping</th>
                            <td class="text-end">{{ number_format($order->shipping, 0, '.', '.') }}đ</td>
                        </tr>
                        <tr>
                            <th>Giảm giá</th>
                            <td class="text-end">{{ number_format($order->discount_amount, 0, '.', '.') }}đ</td>
                        </tr>
                        <tr>
                            <td>
                                <h5 class="text-uppercase">Tổng cộng</h5>
                            </td>
                            <td class="text-end">
                                <h5 class="text-danger">{{ number_format($order->total_final, 0, '.', '.') }}đ</h5>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mt-5 justify-content-center">
            <div class="w-50">
                <h2 class="text-uppercase">Thông tin nhận hàng</h2>
                <div class="table-reponsive">
                    <table class="table">
                        <tr>
                            <th>Họ tên</th>
                            <td class="text-end">{{ $order->fullname }}</td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td class="text-end">{{ $order->address }}</td>
                        </tr>
                        <tr>
                            <th>Số điện thoại</th>
                            <td class="text-end">{{ $order->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td class="text-end">{{ $order->email }}</td>
                        </tr>
                        <tr>
                            <th>Ghi chú đơn hàng</th>
                            <td class="text-end">{{ $order->note }}</td>
                        </tr>
                    </table>
                </div>
                <div class="text-center mt-4">
                    @if (Auth::check())
                        <a href="{{ route('order.detail', $order->id) }}" class="btn-theme">Xem đơn hàng</a>
                    @else
                        <a href="{{ route('home') }}" class="btn-theme">Tiếp tục mua sắm</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection