@extends('admin.layout.master')

@section('content')
    <h2>Danh sách đánh giá</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin-review.index') }}" method="GET"
        class="row align-items-end g-3 mb-4 p-3 shadow-sm rounded border bg-light">
        <!-- Tìm theo mã đơn hàng -->
        <div class="col-md-4">
            <label for="order_code" class="form-label fw-semibold">Mã đơn hàng</label>
            <input type="text" name="order_code" class="form-control" placeholder="Nhập mã đơn hàng..."
                value="{{ request('order_code') }}">
        </div>

        <!-- Tìm theo ngày đánh giá -->
        <div class="col-md-3">
            <label for="review_date" class="form-label fw-semibold">Ngày đánh giá</label>
            <input type="date" name="review_date" class="form-control" value="{{ request('review_date') }}">
        </div>

        <!-- Tìm theo số sao -->
        <div class="col-md-2">
            <label for="rating" class="form-label fw-semibold">Số sao</label>
            <select name="rating" class="form-select">
                <option value="">Tất cả</option>
                @for ($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                        {{ $i }} sao
                    </option>
                @endfor
            </select>
        </div>

        <!-- Nút Tìm kiếm -->
        <div class="col-md-1 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>

        <!-- Nút Reset -->
        <div class="col-md-1 d-flex align-items-end">
            <a href="{{ route('admin-review.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
        </div>
    </form>



    <table class="table table-striped">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Người dùng</th>
                <th>Xếp hạng</th>
                <th>Ngày đánh giá</th> <!-- Cột mới -->
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->order->order_code ?? 'N/A' }}</td>
                    @php
                        $item = \App\Models\OrderItem::where('order_id', $review->order_id)
                            ->where('product_variant_id', $review->product_variant_id)
                            ->first();
                    @endphp
                    <td>
                        @if ($item)
                            {{ $item->product_name }} <br>
                        @else
                            <span class="text-danger">Không tìm thấy</span>
                        @endif
                    </td>
                    <td>{{ $review->user->name ?? 'N/A' }}</td>
                    <td>
                        <p>
                            <strong></strong>
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="fa fa-star{{ $i <= $review->rating ? '' : '-o' }}"
                                    style="color: orange;"></span>
                            @endfor
                        </p>
                    </td>
                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <span class="badge {{ $review->status ? 'bg-success' : 'bg-danger' }}">
                            {{ $review->status ? 'Hiển thị' : 'Đã ẩn' }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin-review.hide', $review->id) }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-sm {{ $review->status ? 'btn-warning' : 'btn-success' }}">
                                {{ $review->status ? 'Ẩn' : 'Hiển thị' }}
                            </button>
                        </form>

                        <a href="{{ route('admin-review.show', $review->id) }}" class="btn btn-sm btn-primary">
                            Chi tiết
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <style>
        table.table {
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        table.table thead th {
            background-color: #f8f9fa;
            text-align: center;
            vertical-align: middle;
            padding: 12px;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #dee2e6;
        }

        table.table tbody td {
            background-color: #ffffff;
            vertical-align: middle;
            padding: 12px;
            border-top: 1px solid #dee2e6;
        }

        .table-striped tbody tr:nth-child(odd) td {
            background-color: #f4f6f9;
        }

        .fa-star,
        .fa-star-o {
            margin-right: 2px;
            font-size: 16px;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 6px 10px;
            border-radius: 4px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 12px;
        }

        .comment-column {
            max-width: 300px;
            max-height: 100px;
            overflow-y: auto;
            word-wrap: break-word;
            white-space: normal;
            padding-right: 5px;
            scrollbar-width: thin;
            scrollbar-color: #ccc transparent;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5c636a;
        }

        h2 {
            font-weight: 700;
            margin-bottom: 20px;
        }
    </style>


    {{ $reviews->links() }} <!-- Phân trang -->
@endsection
