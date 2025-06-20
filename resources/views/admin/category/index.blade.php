@extends('admin.layout.master')

@section('title')
    Danh mục
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded min vh-100 p-4">
                <h6 class="mb-4">Danh sách danh mục</h6>
                <div class="row">
                    <div class="col-md-4">
                        <form method="GET" action="{{ route('admin-category.index') }}">
                            <div class="input-group input-group-sm">
                                <input class="form-control" name="keyword" type="text"
                                    placeholder="Tìm kiếm danh mục theo tên">
                                <button type="submit" class="input-group-text bg-primary text-light"><i
                                        class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class=" col-md-8 text-end">
                        <a href="{{ route('admin-category.create') }}" class="btn btn-sm btn-primary"><i
                                class="fas fa-plus me-2"></i>Tạo mới</a>
                    </div>
                </div>
                <div class="table-responsive mt-3 bg-white p-3">
                    @if ($categories->isNotEmpty())
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên danh mục</th>
                                    <th>Số lượng sản phẩm</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th scope="col" class="text-nowrap text-center" style="width:1px">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $index => $cate)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td>{{ $cate->name }}</td>
                                        <td>{{ $cate->products->count() }}</td>
                                        <td>{{ $cate->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="{{ route('admin-category.edit', $cate->id) }}"
                                                    class="btn text-primary ms-2" title="Sửa"><i
                                                        class="fas fa-pen"></i></a>
                                                @if ($cate->products->isEmpty())
                                                    <form method="post"
                                                        action="{{ route('admin-category.delete', $cate->id) }}"
                                                        class="ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button title="Xóa" class="btn text-danger"
                                                            onclick="return confirm('Bạn có chắc muốn xóa.')"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $categories->links() }}
                    @else
                        <h2>Chưa có danh mục nào.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/category.js')
@endsection
