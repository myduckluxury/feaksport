@extends('client.layout.master')

@section('title')
    Thông tin đơn hàng
@endsection

@section('content')
    <div class="mt-3 mb-5 container">
        <div class="row">
            <div class="col-7">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="text-uppercase">Đơn hàng: {{ $order->order_code }}</h5>
                    </div>
                    @if ($order->status == 'delivered')
                        <form action="{{ route('order.completed', $order->id) }}" method="POST"
                            onsubmit="return confirm('Bạn chắc chắn đã nhận được hàng?')">
                            @csrf
                            <button type="submit" class="btn btn-theme btn-sm">Nhận hàng thành công</button>
                        </form>
                    @elseif (!is_null($reason) && $reason->type == 'return' && $reason->status == 'rejected')
                        <div class="mt-4">
                            <h6>Yêu cầu hoàn trả bị từ chối</h6>
                            <span><strong>Lý do:</strong> {{ $reason->admin_note }}</span>
                        </div>
                    @endif
                </div>
                @if ($order->status == 'unconfirmed')
                    <div class="coupon-accordion mt-4" id="CouponAccordion">
                        <div>
                            <h5>
                                <a href="#" class="btn btn-theme btn-sm" data-bs-toggle="collapse"
                                    data-bs-target="#couponaccordion">Hủy đơn</a>
                            </h5>
                            <div id="couponaccordion" class="collapse" data-bs-parent="#CouponAccordion">
                                <div class="card-body">
                                    <div class="apply-coupon-wrap mb-60">
                                        <form id="request-cancel" action="{{ route('order.cancel-request') }}" method="post">
                                            @csrf
                                            <div class="row">
                                                <div>
                                                    <div class="form-group">
                                                        <textarea class="reason form-control" cols="30" rows="5" type="text"
                                                            placeholder="Nhập lý do huỷ đơn" name="reason" required></textarea>
                                                    </div>
                                                    <div>
                                                        <input name="order_id" value="{{ $order->id }}" hidden>
                                                        @if (Auth::check())
                                                        <input name="user_id" value="{{ Auth::user()->id }}" hidden @endif>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button type="submit"
                                                        onclick="return confirm('Bạn có chắc muốn hủy đơn hàng.')"
                                                        class="btn-theme btn-sm">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif ($order->status == 'delivered')
                    <div class="coupon-accordion mt-4" id="CouponAccordion">
                        <div>
                            <h5>
                                <a href="#" class="btn btn-theme btn-sm" data-bs-toggle="collapse"
                                    data-bs-target="#couponaccordion">Yêu cầu hoàn trả</a>
                            </h5>
                            <div id="couponaccordion" class="collapse mt-4" data-bs-parent="#CouponAccordion">
                                <div class="card-body">
                                    <div class="apply-coupon-wrap mb-60 w-75 ms-1">
                                        <form id="request-return" action="{{ route('order.return-request') }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div>
                                                    <div class="form-group">
                                                        <label for="">Chọn ngân hàng <span
                                                                class="text-danger">*</span></label>
                                                        <select id="bankSelect" name="bank" class="form-select"></select>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="">Số tài khoản <span
                                                            class="text-danger">*</span></label>
                                                            <input type="text" name="bank_account" class="fullname form-control" required placeholder="Nhập số tài khoản">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="">Họ và tên <span
                                                            class="text-danger">*</span></label>
                                                            <input type="text" name="fullname" class="fullname form-control" required placeholder="Nhập đầy đủ họ tên">
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="">Nhập hình ảnh sản phẩm <span
                                                                class="text-danger">*</span></label>
                                                        <input type="file" class="image form-control" multiple name="image[]" id="image" required>
                                                        <span class="error-image text-danger mt-2 "></span>
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <label for="">Lý do <span class="text-danger">*</span></label>
                                                        <textarea class="reason form-control" cols="30" rows="5" type="text"
                                                            placeholder="Nhập lý do hoàn trả" name="reason" required></textarea>
                                                    </div>
                                                    <div>
                                                        <input name="order_id" value="{{ $order->id }}" hidden>
                                                        @if (Auth::check())
                                                        <input name="user_id" value="{{ Auth::user()->id }}" hidden @endif>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button type="submit"
                                                        onclick="return confirm('Bạn có chắc muốn hoàn trả sản phẩm.')"
                                                        class="btn-theme btn-sm">Gửi</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="mt-5 border p-4">
                    <div class="d-flex justify-content-between border-bottom pb-4">
                        <div>
                            <span>Trạng thái:</span>
                            <h3 class="{{ $status[$order->status]['class'] }} text-uppercase">
                                {{ $status[$order->status]['value'] }}
                            </h3 class="{{ $status[$order->status]['class'] }} text-uppercase">
                            <div>
                                @if ($order->status == 'canceled')
                                    <span>{{ $order->reason_cancel }}</span>
                                @elseif ($order->status == 'returned' || $order->status == 'returning')
                                    <span>{{ $order->reason_returned }}</span>
                                @elseif ($order->status == 'failed')
                                    <span>{{ $order->reason_failed }}</span>
                                @endif
                            </div>
                           @if ($reason && $reason->type == 'return' && $reason->status == 'rejected')
                                <span>Yêu cầu hoàn trả bị từ chối, đơn hàng đã được hoàn thành.</span>
                            @elseif ($reason && $reason->status == 'pending')
                                <span>Yêu cầu đang chờ phê duyệt.</span>
                            @endif
                            
                        </div>
                        <div>
                            Ngày tạo:
                            <div>
                                <h4 class="fw-bold">{{ $order->created_at->format('d \T\H\G m, Y') }}</h4>
                            </div>
                        </div>
                    </div>
                    <table class="table mt-4">
                        @foreach ($orderItems as $item)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <img class="rounded" src="{{ Storage::url($item->image_url) }}" width="200" height="110"
                                            alt="">
                                        <div class="ms-4">
                                            <h4 class="product-title">{{ $item->product_name }}</h4>
                                            <div>
                                                <span>Mã sản phẩm: {{ $item->sku }}</span>
                                            </div>
                                            <div>
                                                <span class=" me-3">Kích cỡ: {{ $item->size }}</span>
                                            </div>
                                            <div class="d-flex">
                                                <span class=" me-1">Màu:</span>
                                                <div class="mt-1">
                                                    <span class="rounded-circle border border-secondary shadow "
                                                        style="width: 18px; height: 18px; background-color: {{ $item->color }}; display: inline-block;">
                                                    </span>
                                                </div>
                                            </div>
                                            <div>
                                                <span>Số lượng: {{ $item->quantity }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="col-5">
                <div class="mt-5">
                    <h5 class="text-uppercase">Chi tiết đơn hàng</h5>
                    <div class="table-reponsive">
                        <table class="table">
                            <tr>
                                <th>
                                    <div>
                                        <span>Mã đơn hàng:</span>
                                    </div>
                                    <div class="mb-4">
                                        <span>Ngày đặt hàng:</span>
                                    </div>
                                </th>
                                <td class="text-end">
                                    <div>
                                        <span class="fw-bold">{{ $order->order_code }}</span>
                                    </div>
                                    @php
                                        $day = mb_strtoupper($order->created_at->locale('vi')->translatedFormat('l'));
                                    @endphp
                                    <div>
                                        <span>{{ $day }},
                                            {{ $order->created_at->translatedFormat('d \t\h\g m, Y') }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5 class="text-uppercase">Giao hàng</h5>
                                    </div>
                                </td>
                                <td class="text-end border-bottom-0">
                                    <div class="mt-4">
                                        <span><i class="fa fa-truck fa-lg" aria-hidden="true"></i></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold">Địa chỉ giao hàng</span>
                                    </div>
                                    <div class="mb-4 mt-3">
                                        <span class="d-block">{{ $order->fullname }}</span>
                                        <span class="d-block">{{ $order->address }}</span>
                                        <span class="d-block">{{ $order->phone_number }}</span>
                                        <span class="d-block">{{ $order->email }}</span>
                                    </div>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5 class="text-uppercase">Phương thức</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="mb-4">
                                        <span class="small">{{ $payment_method[$order->payment_method] }}</span>
                                    </div>
                                    @if ($order->payment_method != 'COD')
                                        <div class="mb-4">
                                            <span
                                                class="small fw-bold {{ $payment_status[$order->payment_status]['class'] }}">{{ $payment_status[$order->payment_status]['value'] }}</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <span>
                                        @if ($order->payment_method == 'COD')
                                            <i class="fa fa-money fa-lg" aria-hidden="true"></i>
                                        @else
                                            <i class="fa fa-credit-card fa-lg" aria-hidden="true"></i>
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="border-bottom-0">
                                    <div class="mt-4">
                                        <h5>TỔNG</h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div>
                                        <span>{{ $order->orderItems->sum('quantity') }} mặt hàng</span>
                                    </div>
                                    <div>
                                        <span>Giảm giá</span>
                                    </div>
                                    <div>
                                        <span>Giao hàng:</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">Tổng:</span>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <div>
                                        <span>{{ number_format($order->orderItems->sum(fn($item) => $item->quantity * $item->unit_price), 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span>{{ number_format($order->discount_amount, 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span>{{ number_format($order->shipping, 0, '.', '.') }}đ</span>
                                    </div>
                                    <div>
                                        <span class="fw-bold">{{ number_format($order->total_final, 0, '.', '.') }}đ</span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script> const orderId = {{ $order->id }} </script>
    <script src="{{ asset('client/js/order.js') }}"></script>
    @vite('resources/js/order/status.js')
@endsection