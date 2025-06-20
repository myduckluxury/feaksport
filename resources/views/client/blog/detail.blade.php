@extends('client.layout.master')

@section('title', $blog->title)

@section('content')
    <style>
        .blog-detail {
            background: #fff;
            padding: 50px 0;
        }
        .post-title {
            font-size: 2.2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
        }
        .meta-info {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }
        .meta-info ul {
            list-style: none;
            padding: 0;
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        .meta-info i {
            margin-right: 5px;
        }
        .post-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            text-align: justify;
            padding: 0 15px;
        }
        .back-btn {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        .back-btn a {
            background: #007bff;
            color: #fff;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        .back-btn a:hover {
            background: #0056b3;
        }
    </style>

    <section class="blog-detail">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h1 class="post-title">{{ $blog->title }}</h1>

                    <div class="meta-info">
                        <ul>
                            <li><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</li>
                            <li><i class="fa fa-user"></i> {{ $blog->author }}</li>
                        </ul>
                    </div>

                    <div class="text-center">
                        <img src="{{ asset('storage/' . $blog->image_url) }}" class="post-image" alt="{{ $blog->title }}">
                    </div>

                    <div class="post-content">
                        {!! nl2br(e($blog->content)) !!}
                    </div>

                    <div class="back-btn">
                        <a href="{{ route('blog.index') }}"><i class="fa fa-arrow-left"></i> Quay lại danh sách</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
