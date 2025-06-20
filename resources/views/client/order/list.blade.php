@extends('client.layout.master')

@section('title')
    Lịch sử mua hàng
@endsection

@section('content')
    <div class="mt-5 mb-5 container">
        <div>
            <h3 class="text-uppercase text-center">Đơn hàng của bạn</h3>
        </div>
        <div class="row justify-content-center">
            @if ($orders->count() > 0)
                <div class="w-75 mt-5">
                    @foreach ($orders as $order)
                        <a href="{{ route('order.detail', $order->id) }}">
                            <div class="border p-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="fw-bold">
                                            Mã đơn: {{ $order->order_code }} | Thành tiền: <span
                                                class="fw-bold text-danger">{{ number_format($order->total_final, 0, '.', '.') }}đ</span>
                                        </h6>
                                        <span class="mb-2">Ngày tạo:
                                            {{ $order->created_at->format('d \T\h\á\n\g m, Y') }}</span>
                                    </div>
                                    <div>
                                        <span>Phương thức thanh toán</span>
                                        <div>
                                            <span
                                                class="text-dark d-block">{{ $payment_method[$order->payment_method] }}</span>
                                            @if ($order->payment_method != 'COD')
                                                <span
                                                    class="d-block fw-bold text-dark">{{ $payment_status[$order->payment_status] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    @foreach ($order->orderItems as $key => $item)
                                        <!-- Chỉ hiển thị sản phẩm đầu tiên trên mobile -->
                                        @if ($key == 0)
                                            <div class="d-flex me-3">
                                                <img src="{{ Storage::url($item->image_url) }}"
                                                    alt="Ảnh sản phẩm" class="img-fluid ms-2 rounded" width="100">
                                                <div class="ms-2">
                                                    <div>
                                                        <small class="text-dark fw-bold d-block">
                                                            {{ $item->name }}
                                                        </small>
                                                        <small class="text-dark d-block">
                                                            <strong>Số lượng:</strong> {{ $item->quantity }}
                                                        </small>
                                                        <small class="text-dark d-block">
                                                            <strong>Kích cỡ:</strong> {{ $item->size }}
                                                        </small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div>
                                                            <small class="text-dark fw-bold">Màu sắc:</small>
                                                        </div>
                                                        <div class="rounded-circle border border-secondary shadow mt-2 ms-2"
                                                            style="width: 16px; height: 16px; background-color: {{ $item->color }};">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Hiển thị sản phẩm thứ 2 trở đi trên màn hình lớn -->
                                        @if ($key == 1)
                                            <div class="d-none d-md-flex me-3">
                                                <img src="{{ Storage::url($item->image_url) }}"
                                                    alt="Ảnh sản phẩm" class="img-fluid ms-2 rounded" width="100">
                                                <div class="ms-2">
                                                    <div>
                                                        <small class="text-dark fw-bold d-block">
                                                            {{ $item->name }}
                                                        </small>
                                                        <small class="text-dark d-block">
                                                            <strong>Số lượng:</strong> {{ $item->quantity }}
                                                        </small>
                                                        <small class="text-dark d-block">
                                                            <strong>Kích cỡ:</strong> {{ $item->size }}
                                                        </small>
                                                    </div>
                                                    <div class="d-flex">
                                                        <div>
                                                            <small class="text-dark fw-bold">Màu sắc:</small>
                                                        </div>
                                                        <div class="rounded-circle border border-secondary shadow mt-2 ms-2"
                                                            style="width: 16px; height: 16px; background-color: {{ $item->color }};">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                        </a>
                    @endforeach
                    <div class="mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <div class="mt-5">
                    <h5 class="text-center">Chưa có đơn hàng nào</h5>
                </div>
            @endif
        </div>
    </div>
@endsection
