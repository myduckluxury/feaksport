@extends('admin.layout.master')

@section('title')
    Thêm mới bài viết
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div id="form-blog" class="bg-light rounded min vh-100 p-4">
                <form action="{{ route('admin-blog.store') }}" id="blog-form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề bài viết</label>
                        <input type="text" name="title" class="form-control mb-2">
                        <span class="text-danger error-title"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nội dung bài viết</label>
                        <textarea name="content" class="form-control mb-2" rows="5"></textarea>
                        <span class="text-danger error-content"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tác giả</label>
                        <input type="text" name="author" class="form-control mb-2">
                        <span class="text-danger error-author"></span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hình ảnh</label>
                        <input type="file" name="image_url" class="form-control mb-2">
                        <span class="text-danger error-image_url"></span>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('admin-blog.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Danh sách
                        </a>
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="fas fa-save me-2"></i> Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $("#blog-form").on("submit", function (e) {
                e.preventDefault();
    
                let form = $(this);
                let formData = new FormData(this);
    
                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function (response) {
                        if (response.status === "success") {
                            // Hiển thị thông báo thành công ngay lập tức
                            toastr.success(response.message);
    
                            // Reset form sau khi thêm thành công
                            form[0].reset();
    
                            // Thêm bài viết mới vào danh sách mà không cần reload trang
                            $("#blog-list").prepend(`
                                <tr>
                                    <td>${response.data.id}</td>
                                    <td>${response.data.title}</td>
                                    <td>${response.data.author}</td>
                                    <td><img src="${response.data.image_url}" width="50"></td>
                                    <td>${response.data.created_at}</td>
                                </tr>
                            `);
                            setTimeout(function () {
                                window.location.href = "{{ route('admin-blog.index') }}";
                            }, 1500);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
    
                        // Xóa thông báo lỗi cũ
                        $(".error-title, .error-content, .error-author, .error-image_url").text("");
    
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.title) $(".error-title").text(errors.title[0]);
                            if (errors.content) $(".error-content").text(errors.content[0]);
                            if (errors.author) $(".error-author").text(errors.author[0]);
                            if (errors.image_url) $(".error-image_url").text(errors.image_url[0]);
                        }
                    }
                });
            });
        });
    </script>
    
    
@endsection
