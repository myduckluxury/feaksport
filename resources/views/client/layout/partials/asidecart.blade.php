<div class="aside-cart-wrapper offcanvas offcanvas-end" tabindex="-1" id="AsideOffcanvasCart"
    aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h1 id="offcanvasRightLabel"></h1>
        <button class="btn-aside-cart-close" data-bs-dismiss="offcanvas" aria-label="Close">Giỏ hàng<i
                class="fa fa-chevron-right"></i></button>
    </div>
    @php
        use Illuminate\Support\Str;
    @endphp
    @if (session('cart'))
        <div class="offcanvas-body">
            @php
                $totalPrice = collect(session('cart', []))->sum(function ($item) {
                    return $item['quantity'] * $item['price'];
                });
            @endphp
            <ul class="aside-cart-product-list">
                @foreach (session('cart') as $cart)
                    <li class="product-list-item d-flex justify-content-between">
                        <div>
                            <a href="{{ route('product.detail', ['id' => $cart['product_id'], 'slug' => Str::slug($cart['name'])]) }}">
                                <img src="{{ Storage::url($cart['image']) }}" width="90" height="110"
                                    alt="Image-HasTech">
                                <span class="product-title">{{ $cart['name'] }}</span>
                            </a>
                            <span class="product-price">{{ $cart['quantity'] }} ×
                                {{ number_format($cart['price']) }}đ</span>
                            <div class="d-flex">
                                <span class="small me-3">Kích cỡ: {{ $cart['size'] }}</span>
                                <span class="small me-1">Màu:</span>
                                <div>
                                    <span class="rounded-circle border border-secondary shadow small"
                                        style="width: 15px; height: 15px; background-color: {{ $cart['color'] }}; display: inline-block;">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <form class="delete-item-cart ms-2" action="{{ route('cart.delete.product', $cart['id']) }}"
                            method="post">
                            @csrf
                            @method('DELETE')
                            <div>
                                <button class="btn btn-lg" type="submit">×</button>
                            </div>
                        </form>
                    </li>
                @endforeach
            </ul>
            <p class="cart-total"><span>Tổng:</span><span
                    class="amount fw-bold text-danger">{{ number_format($totalPrice) }}đ</span></p>
            <a class="btn-theme" data-margin-bottom="10" href="{{ route('cart.index') }}">Xem giỏ hàng</a>
            <a class="btn-theme" href="{{ route('order.index') }}">Thanh toán</a>
        </div>
    @else
        <div class="mt-3">
            <h5 class="text-center">Chưa có sản phẩm nào.</h5>
        </div>
    @endif
</div>
