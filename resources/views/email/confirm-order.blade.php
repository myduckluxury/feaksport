<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận đơn hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
        }

        h1 {
            color: #333;
            font-size: 24px;
        }

        h2 {
            font-size: 18px;
            color: #555;
        }

        p {
            font-size: 14px;
            line-height: 1.6;
            color: #555;
        }

        .order-summary {
            margin-top: 20px;
        }

        .order-summary th,
        .order-summary td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .order-summary th {
            background-color: #f2f2f2;
        }

        .highlight {
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Cảm ơn bạn đã tin tưởng FreakSport</h1>
        <h4>
            Mã đơn hàng: {{ $order->order_code }}</h4>

        <p>Xin chào {{ $order->fullname }},</p>
        <p>Chúng tôi đã nhận được đơn hàng của bạn và sẽ gửi cho bạn xác nhận giao hàng cùng với thông tin theo dõi &
            theo dõi ngay khi đơn hàng của bạn được chuyển đi. Chúng tôi mong bạn thông cảm và kiên nhẫn trong thời gian
            này.</p>

        <h2>Tóm Tắt Đơn Hàng</h2>
        <table class="order-summary">
            <tr>
                <th>Địa chỉ giao hàng</th>
                <td>{{ $order->address }}<br>Số điện thoại:
                    {{ $order->phone_number }}
                </td>
            </tr>
            <tr>
                <th>Phương thức thanh toán</th>
                <td>{{ $order->payment_method == 'COD' ? 'Thanh toán khi nhận hàng.' : ($order->payment_method == 'ATM' ? 'Thanh toán qua VNPay' : 'Thanh toán qua ví MOMO') }}
                </td>
            </tr>
            <tr>
                <th>Ngày đặt</th>
                <td>{{ $order->created_at->format('d \t\h\á\n\g m, Y') }}</td>
            </tr>
            @foreach ($orderItems as $item)
                <tr>
                    <th>Sản phẩm</th>
                    <td>{{ $item->product_variant->product->name }} (Số lượng: {{ $item->quantity }})<br>Màu sắc: <span
                            style="width: 18px; height: 18px; border: 1px solid #333; border-radius: 50%; background-color: {{ $item->product_variant->color }}; display: inline-block;">
                        </span><br>Kích
                        thước:
                        {{ $item->product_variant->size }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <th>Tổng giá trị</th>
                <td class="highlight">{{ number_format($order->total_final, 0, '.','.' )}}đ</td>
            </tr>
            <tr>
                <th>Vận chuyển</th>
                <td>{{ number_format($order->shipping, 0, '.', '.') }}đ</td>
            </tr>
        </table>

        <div class="footer">
            <p>Cảm ơn bạn đã mua sắm tại FreakSport!</p>
            <p><a href="{{ route('home') }}" target="_blank">Truy cập website của chúng tôi</a></p>
        </div>
    </div>
</body>

</html>