<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h2>Xin chào {{ $user->name }},</h2>
    <p>Vui lòng nhấn vào liên kết bên dưới để xác thực tài khoản của bạn trên FreakSport.</p>
    <p>
        <a href="{{ route('verify-email',$user->email) }}">Click vào đây để xác thực tài khoản.</a>
    </p>
    <p>Cảm ơn.</p>
</body>

</html>