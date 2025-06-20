@extends('client.layout.master')

@section('title', 'Tin tức')

@section('content')
<style>
    .blog-area {
        background: #f8f9fa;
        padding: 50px 0;
    }
    .post-item {
        transition: all 0.3s ease-in-out;
        background: white;
        border-radius: 8px;
        overflow: hidden;
    }
    .post-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.15);
    }
    .post-item .thumb img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }
    .post-item .content {
        padding: 15px;
    }
</style>
    <!--== Start Blog Area Wrapper ==-->
    <section class="blog-area blog-inner-area py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2 class="font-weight-bold">Tin tức mới nhất</h2>
                <p class="text-muted">Cập nhật những bài viết mới nhất mỗi ngày</p>
            </div>
            <div class="row">
                @if ($blogs->isNotEmpty())
                    @foreach ($blogs as $blog)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <!--== Start Blog Item ==-->
                            <div class="post-item shadow-lg border rounded overflow-hidden">
                                <div class="inner-content">
                                    <div class="thumb position-relative">
                                        <a href="{{ route('blog.detail', $blog->id) }}">
                                            <img src="{{ asset('storage/' . $blog->image_url) }}" class="img-fluid rounded-top" alt="{{ $blog->title }}">
                                        </a>
                                    </div>
                                    <div class="content p-3">
                                        <div class="meta-post d-flex justify-content-between align-items-center text-muted">
                                            <span><i class="fa fa-calendar"></i> {{ $blog->created_at->format('d/m/Y') }}</span>
                                            <span><i class="fa fa-user"></i> {{ $blog->author }}</span>
                                        </div>
                                        <h4 class="title mt-2">
                                            <a href="{{ route('blog.detail', $blog->id) }}" class="text-dark font-weight-bold">{{ $blog->title }}</a>
                                        </h4>
                                        <p class="text-muted small">{{ Str::limit(strip_tags($blog->content), 120, '...') }}</p>
                                        <a class="post-btn btn btn-primary btn-sm mt-2" href="{{ route('blog.detail', $blog->id) }}">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                            <!--== End Blog Item ==-->
                        </div>
                    @endforeach
                @else
                    <h4 class="text-center text-muted">Chưa có bài viết nào.</h4>
                @endif
            </div>

            <!-- Phân trang -->
            <div class="d-flex justify-content-center mt-4">
                {{ $blogs->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
    <!--== End Blog Area Wrapper ==-->
@endsection
