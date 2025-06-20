<!DOCTYPE html>
<html lang="zxx">


<!-- Mirrored from htmldemo.net/shome/shome/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jan 2025 15:04:17 GMT -->

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Shome - Shoes eCommerce Website Template" />
  <meta name="keywords" content="footwear, shoes, modern, shop, store, ecommerce, responsive, e-commerce" />
  <meta name="author" content="codecarnival" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  

  <title>Freak Sport - @yield('title')</title>

  <!--== Favicon ==-->  
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">  lỗi ở đây --}}

  <link rel="shortcut icon" href="{{ asset('client/img/favicon.icon')}}" type="image/x-icon" />

  {{-- Css file --}}
  @include('client.layout.partials.css')

  <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js')}}"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js')}}"></script>
    <![endif]-->
</head>

<body>

  <!--wrapper start-->
  <div class="wrapper">

    <!--== Start Header Wrapper ==-->
    @include('client.layout.partials.header')
    <!--== End Header Wrapper ==-->

    <main class="main-content">
        @yield('content')
    </main>

    <!--== Start Footer Area Wrapper ==-->
    @include('client.layout.partials.footer')
    <!--== End Footer Area Wrapper ==-->

    <!--== Scroll Top Button ==-->
    <div id="scroll-to-top" class="scroll-to-top"><span class="fa fa-angle-up"></span></div>

    <!--== Start Aside Cart Menu ==-->
    @include('client.layout.partials.asidecart')
    <!--== End Aside Cart Menu ==-->


    @include('client.layout.partials.mobilemenu')

  </div>

  <!--=======================Javascript============================-->
  @include('client.layout.partials.js')

</body>


<!-- Mirrored from htmldemo.net/shome/shome/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 20 Jan 2025 15:04:43 GMT -->

</html>