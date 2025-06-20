<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="">
        <h4>Xin chào {{ $user->name }}</h4>
        <p>
            Chúng tôi vừa nhận được thông tin khôi phục mật khẩu từ bạn vào lúc
            {{ $now->format('H:i \n\g\à\y d \t\h\á\n\g m, Y') }}.
            Vui lòng nhập vào liên kết bên dưới để khôi phục mật khẩu của bạn.
        <div>
            <a href="{{ route('forgot-password.confirm', $token) }}">Click vào đây để khôi phục mật khẩu.</a>
        </div>
        </p>
    </div>
</body>

</html>
