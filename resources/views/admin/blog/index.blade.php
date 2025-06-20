@extends('admin.layout.master')

@section('title')
    Danh sách bài viết
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded p-4">
                <h6 class="mb-4">Danh sách bài viết</h6>

                <div class="col-md-4">
                    <form method="GET" action="{{ route('admin-blog.index') }}">
                        <div class="input-group input-group-sm">
                            <input class="form-control border-0" name="keyword" type="text"
                                placeholder="Tìm kiếm tên tiêu đề - Tên tác giả" value="{{ request('keyword') }}">
                            <button type="submit" class="input-group-text bg-primary text-light"><i
                                    class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin-blog.index') }}">
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    <label for="date">Chọn ngày:</label>
                                    <input type="date" class="form-control form-control-sm" name="date" id="date"
                                        value="{{ request('date') }}">
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-primary mt-3"><i class="fas fa-filter"></i> Lọc</button>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="text-end col-md-6">
                        <a href="{{ route('admin-blog.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm mới
                        </a>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    @if ($blogs->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Tác giả</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col" class="text-center">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $index => $blog)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->author }}</td>
                                        <td>
                                            @if ($blog->image_url)
                                                <img src="{{ asset('storage/' . $blog->image_url) }}" width="100"
                                                    class="rounded">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('admin-blog.edit', $blog->id) }}"
                                                    class="btn text-primary me-2" title="Sửa">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin-blog.delete', $blog->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn text-danger" title="Xóa"
                                                        onclick="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                                        <i class="far fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $blogs->links() }}
                    @else
                        <h4 class="text-center text-muted">Chưa có bài viết nào.</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/blog.js')
@endsection
