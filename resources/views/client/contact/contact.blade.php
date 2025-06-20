@extends('client.layout.master')

@section('title')
    Liên hệ
@endsection

@section('content')
    <div class="contact-section position-relative">
        <!-- Hình nền co giãn theo kích thước -->
        <img src="https://photo2.tinhte.vn/data/attachment-files/2023/02/6314655_hoka-13.jpg"
             class="bg-img" alt="background">

        <div class="container position-relative" style="z-index: 1;">
            <h2 class="text-center mb-4 text-white">Liên Hệ Với Chúng Tôi</h2>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="contact-form">
                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold text-white">Họ và Tên</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold text-white">Số điện thoại</label>
                                <input type="number" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold text-white">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label fw-bold text-white">Nội Dung</label>
                                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-custom w-100">Gửi Tin Nhắn</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!\1m3!1d3723.863806019075!2d105.74468687471467!3d21.038134787457583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1740458028817!5m2!1svi!2s"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .contact-section {
            position: relative;
            overflow: hidden;
            padding: 50px 0;
        }

        .bg-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain; 
            z-index: 0;
            opacity: 0.8;
        }

        .contact-form {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .contact-map {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 10px;
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #ff6600;
            color: white;
            font-weight: bold;
            border: none;
            padding: 10px;
            transition: 0.3s ease-in-out;
        }

        .btn-custom:hover {
            background-color: #e65c00;
        }

        .form-control {
            border: 2px solid #ff6600;
            border-radius: 8px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            border-color: #e65c00;
            box-shadow: none;
        }
    </style>
@endsection
