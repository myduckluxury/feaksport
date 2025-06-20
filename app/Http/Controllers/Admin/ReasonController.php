<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageReturn;
use App\Models\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function index()
    {
        $query = Reason::query();

        $return = $query->where('type', 'return')->latest('id')->paginate(10);

        $status = [
            'pending' => ['value' => 'Chờ duyệt.', 'class' => 'text-secondary'],
            'approved' => ['value' => 'Đã duyệt.', 'class' => 'text-primary'],
            'rejected' => ['value' => 'Từ chối.', 'class' => 'text-danger'],
        ];

        return view('admin.order.return', compact('return', 'status'));
    }

    public function detail(Reason $reason) {
        $images = ImageReturn::where('reason_id', $reason->id)->get();
        $status = [
            'pending' => ['value' => 'Chờ duyệt', 'class' => 'text-secondary'],
            'approved' => ['value' => 'Đã xử lý', 'class' => 'text-success'],
            'rejected' => ['value' => 'Từ chối', 'class' => 'text-danger'],
        ];
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD).',
            'VNPAY' => "Thanh toán qua VNPay.",
            'MOMO' => 'Ví điện tử MOMO.'
        ];
        
        return view('admin.order.detail-return', compact('reason',
                                                        'images',
                                                                    'status',
                                                                    'payment_method'));
    }
}
