@extends('client.layout.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    <!--== Start Blog Area Wrapper ==-->
    <section class="shopping-cart-area">
        <div class="container">
            @if (session('cart'))
                <form id="update-cart" action="{{ route('cart.update') }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="shopping-cart-form table-responsive" style="overflow-x: auto;">
                                <table class="table text-center"  style="font-size: 14px;">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th class="product-name text-center">Sản phẩm</th>
                                            <th class="product-price">Giá</th>
                                            <th class="product-quantity">Số lượng</th>
                                            <th class="product-subtotal">Tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach (session('cart') as $cart)
                                            <tr class="cart-product-item">
                                                <td>
                                                    <div class="me-3">
                                                        <input type="checkbox" class="cart-checkbox" checked name="id[]" value="{{ $cart['id'] }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('product.detail', ['id' => $cart['product_id'], 'slug' => Str::slug($cart['name'])]) }}">
                                                        <img class="rounded" src="{{ Storage::url($cart['image']) }}" width="100"
                                                            alt="Image-HasTech">
                                                    </a>
                                                </td>
                                                <td class="product-name">
                                                    <div>
                                                        <h5 class="fw-bold text-center">
                                                            <a href="{{ route('product.detail', ['id' => $cart['product_id'], 'slug' => Str::slug($cart['name'])]) }}"
                                                                class="text-dark">{{ $cart['name'] }}</a>
                                                        </h5>
                                                        <div class="row justify-content-center">
                                                            <div class="col-auto">
                                                                <span class="fw-bold small">Kích cỡ: {{ $cart['size'] }}</span>
                                                            </div>
                                                            <div class="col-auto d-flex align-items-center">
                                                                <span class="fw-bold small">Màu sắc:</span>
                                                                <span class="rounded-circle border border-secondary shadow ms-2"
                                                                    style="width: 22px; height: 22px; background-color: {{ $cart['color'] }}; display: inline-block;">
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </td>
                                                <td class="product-price">
                                                    <span
                                                        class="price text-danger"><strong>{{ number_format($cart['price']) }}đ</strong></span>
                                                </td>
                                                <td class="product-quantity">
                                                    <div class="pro-qty">
                                                        <div class="d-flex">
                                                            <div class= "dec qty-btn d-flex align-items-center justify-content-center">-</div>
                                                            <input type="text" class="quantity" title="Quantity" name="quantity[{{ $cart['id'] }}]"
                                                            value="{{ $cart['quantity'] }}">
                                                            <div class="inc qty-btn d-flex align-items-center justify-content-center">+</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="product-subtotal">
                                                    <span
                                                        class="price text-danger"><strong>{{ number_format($cart['price'] * $cart['quantity']) }}đ</strong></span>
                                                </td>
                                                {{-- <td class="product-remove">
                                                        <form class="delete-item-cart" action="{{ route('cart.delete.product', $cart['id']) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div>
                                                                <button class="btn text-danger" type="submit"><i class="fa fa-trash-o"></i></button>
                                                            </div>
                                                        </form>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr class="actions">
                                        <td class="border-0" colspan="6">
                                                <button type="submit" name="action" value="update" class="update-cart">Cập nhật giỏ hàng</button>
                                                <a href="{{ route('cart.delete') }}" class="btn-theme btn-flat clear cart">Xóa giỏ hàng</a>
                                                <a href="{{ route('product.index') }}" class="btn-theme btn-flat">Tiếp tục mua
                                                    sắm</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row row-gutter-50 justify-content-end">
                        <div class="col-md-12 col-lg-6">
                            <div class="shipping-form-cart-totals">
                                <div class="section-title-cart">
                                    <h3 class="text-center">Tổng giỏ hàng</h3>
                                </div>
                                <div class="cart-total-table">
                                    <table class="table">
                                        <tbody>
                                            <tr class="cart-subtotal">
                                                <td>
                                                    <p class="value">Tổng giá:</p>
                                                </td>
                                                <td class="">
                                                    <p class="price" id="selected-price">0đ</p>
                                                </td>
                                            </tr>
                                            <tr class="shipping">
                                                <td>
                                                    <p class="value">Vận chuyển:</p>
                                                </td>
                                                <td>
                                                    <p class="price">50.000đ</p>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <td>
                                                    <h6 class="value">Tổng:</h6>
                                                </td>
                                                <td>
                                                    <h6 class="price text-danger" id="selected-total">0đ</h6>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn-theme btn-flat w-100" name="action" value="filter">Thanh toán</button>

                            </div>
                        </div>
                    </div>
                </form>
            @else
                <h3 class="text-center mb-5">Chưa có sản phẩm nào trong giỏ hàng.</h3>
                <div class="text-center">
                    <a href=" {{ route('product.index') }}" class="btn-theme btn-sm"><i class="fa fa-arrow-left me-2"
                            aria-hidden="true"></i>Quay về trang mua sắm</a>
                </div>
            @endif
        </div>
    </section>
    <script>
        var orderIndexUrl = "{{ route('order.index') }}";
        window.cartRoute = "{{ route('cart.index') }}";
    </script>
    <!--== End Blog Area Wrapper ==-->
@endsection