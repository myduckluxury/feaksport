@extends('admin.layout.master')

@section('title')
    Lịch sử cập nhật đơn hàng
@endsection

@section('content')
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded vh-100 p-4">
                <h6 class="mb-4">Lịch sử cập nhật đơn hàng</h6>
                <div>
                    <a href="{{ route('admin-order.detail', $order->id) }}" class="btn btn-sm btn-secondary"><i
                        class="fas fa-arrow-left me-2"></i>Trở về</a>
                </div>
                <div class="bg-white mt-3 p-2">
                    @if ($histories->isNotEmpty())
                        <div class="table-reponsive">
                            <table class="table table-striped">
                                <thead>
                                    <th class="text-center">Thời gian</th>
                                    <th>Người cập nhật</th>
                                    <th>Chức vụ</th>
                                    <th>Nội dung</th>
                                    
                                </thead>
                                <tbody>
                                    @foreach ($histories as $history)
                                        <tr>
                                            <td class="text-center">{{  $history->changed_at->format('H:i, d \t\h\á\n\g m, Y')  }}</td>
                                            <td><span class="text-primary">{{ $history->user->email }}</span></td>
                                            <td><span class="{{$role[$history->user->role]['class']}} fw-bold">{{ $role[$history->user->role]['value'] }}</span></td>
                                            <td><span>{{ $history->note }}</span></td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h6>Lịch sử trống</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection