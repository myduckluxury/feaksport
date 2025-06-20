@extends('admin.layout.master')

@section('title')
    Dashboard
@endsection

@section('content')
    <!-- Sale & Revenue Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số người dùng</p>
                        <h6 class="mb-0">{{ $totalUsers }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-clipboard fa-3x text-warning"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số đơn hàng đã bán</p>
                        <h6 class="mb-0">{{ $totalOrders }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-gift fa-3x text-danger"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng số lượt bán sản phẩm</p>
                        <h6 class="mb-0">{{ $totalSales }}</h6>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fas fa-wallet fa-3x text-success"></i>
                    <div class="ms-3">
                        <p class="mb-2">Tổng doanh thu trong tháng</p>
                        <h6 class="mb-0">{{ number_format($totalRevenueMonth, 0, '.', '.') }}đ</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Sale & Revenue End -->


    <!-- Sales Chart Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12 col-xl-12">
                <div class="bg-light text-center rounded p-4">
                    <div>
                        <form method="GET" action="{{ route('dashboard.index') }}" class="d-flex gap-3 mb-4 ">
                            <div class="form-group">
                                <label for="">Ngày bắt đầu</label>
                                <div class="input-group-sm date" id="fromDatePicker">
                                    <input type="date" name="from" class="form-control datetimepicker-input"
                                        value="{{ request()->input('from') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Ngày kết thúc</label>
                                <div class="input-group-sm date" id="toDatePicker">
                                    <input type="date" name="to" class="form-control datetimepicker-input"
                                        value="{{ request()->input('to') }}">
                                </div>
                            </div>

                            <div class="d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-sm"><i
                                        class="fas fa-filter me-2"></i>Lọc</button>
                                <a href="{{ route('dashboard.index') }}" class="btn btn-secondary btn-sm ms-2">
                                    <i class="fas fa-sync me-2"></i>Reset
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="mb-4">Doanh thu các tháng</h5>
                        <h6>Tổng doanh thu 3 tháng gần nhất: <span
                                class="text-danger">{{ number_format($totalRevenue, 0, '.', '.') }}đ</span></h6>
                    </div>
                    <canvas class="bg-white p-3" id="line-chart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Sales Start -->
        <div class="container-fluid mb-3 pt-4 px-4 bg-light mt-4">
            <div class="row">
                <div class="col-8">
                    <div class="bg-light rounded h-100 p-4">
                        <h6 class="mb-4">Lượt bán sản phẩm theo thương hiệu</h6>
                        <canvas id="doughnut-chart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="h-100 bg-light rounded p-4 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <h6 class="mb-0">Top sản phẩm được quan tâm</h6>
                        </div>
                        @foreach ($productView as $view)
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img class=" rounded flex-shrink-0"
                                    src="{{ Storage::url($view->imageLists->first()->image_url) }}" alt="" width="60">
                                <div class="w-100 ms-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-0">{{ $view->view }} <i class="far fa-eye fa-sm text-primary"></i>
                                        </h6>
                                        <small
                                            class="badge bg-primary">{{ number_format($view->variants->min()->price, 0, '.', '.') }}đ</small>
                                    </div>
                                    <span>{{ $view->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Sales End -->


        <script>
            let revenueData = @json($revenueMonth);

            let labelsRevenue = Object.keys(revenueData);
            let dataRevenue = Object.values(revenueData);

            const brandLabels = {!! json_encode($brandLabels) !!};
            const brandSales = {!! json_encode($brandSales) !!};
        </script>
@endsection