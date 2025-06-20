@extends('admin.layout.master')

@section('title')
    Chỉnh sửa bài viết
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Chỉnh sửa bài viết</h6>

                <form action="{{ route('admin-blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề bài viết</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $blog->title) }}">
                        @error('title') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nội dung bài viết</label>
                        <textarea name="content" class="form-control" rows="5">{{ old('content', $blog->content) }}</textarea>
                        @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tác giả</label>
                        <input type="text" name="author" class="form-control" value="{{ old('author', $blog->author) }}">
                        @error('author') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Hình ảnh hiện tại</label><br>
                        @if ($blog->image_url)
                            <img src="{{ asset('storage/' . $blog->image_url) }}" width="150" class="rounded mb-2">
                        @else
                            <p class="text-muted">Không có ảnh</p>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cập nhật hình ảnh</label>
                        <input type="file" name="image_url" class="form-control">
                        @error('image_url') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('admin-blog.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-2"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
