<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ mới</title>
</head>
<body>
    <h2>Thông tin liên hệ mới</h2>
    <p><strong>Họ và tên:</strong> {{ $data['name'] }}</p>
    <p><strong>Số điện thoại:</strong> {{ $data['phone'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Nội dung:</strong></p>
    <p>{{ $data['message'] }}</p>
</body>
</html>