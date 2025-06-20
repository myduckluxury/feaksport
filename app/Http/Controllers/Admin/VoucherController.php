<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class VoucherController extends Controller
{

    public function index(Request $request)
    {
        // $vouchers = Voucher::latest('id')->paginate(10);
        $kind = [
            'total' => 'Giảm theo tổng đơn hàng',
            'shipping' => 'Giảm phí vận chuyển',
        ];

        
        $query = Voucher::query(); 

        if ($request->has(['start_date', 'end_date'])) {
            $request->validate([
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);
    
            $start = $request->start_date;
            $end = $request->end_date;
    
            $query->whereDate('start_date', '>=', $start)
                     ->whereDate('expiration_date', '<=', $end);
        }
    
        $vouchers = $query->latest('id')->paginate(10);
    

        return view('admin.voucher.index', compact('vouchers', 'kind'));
    }


    public function create()
    {
        return view('admin.voucher.create');
    }


    public function store(Request $request)
    {
        if ($request['type'] == 'fixed' || $request['kind'] == 'shipping') {
            $request['max_discount'] = 0;
        }
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:4', Rule::unique('vouchers')->whereNull('deleted_at')],
            'type' => ['required'],
            'kind' => ['required'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_total' => ['required'],
            'max_discount' => ['required'],
            'quantity' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'name.required' => 'Tên khuyến mãi không được để trống.',
            'code.required' => 'Mã khuyến mãi không được để trống.',
            'code.min' => 'Mã khuyến mãi phải có ít nhất 4 ký tự.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại, vui lòng nhập mã khác.',
            'value.required' => 'Giá trị khuyến mãi không được để trống.',
            'value.numeric' => 'Giá trị khuyến mãi phải là số.',
            'value.min' => 'Giá trị khuyến mãi phải lớn hơn hoặc bằng 0.',
            'min_total.required' => 'Không được trống.',
            'max_discount.required' => 'Không được trống.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'expiration_date.required' => 'Ngày hết hạn không được để trống.',
            'expiration_date.date' => 'Ngày hết hạn không hợp lệ.',
            'expiration_date.after_or_equal' => 'Ngày hết hạn phải từ hôm nay trở đi.',
        ]);

        $voucher = Voucher::create($data);
        event(new \App\Events\Voucher($voucher));

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm khuyến mãi thành công.'
        ], Response::HTTP_OK);
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.voucher.edit', compact('voucher'));
    }


    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'code' => ['required', 'string', 'min:4', Rule::unique('vouchers')->whereNull('deleted_at')->ignore($voucher->id)],
            'type' => ['required'],
            'kind' => ['required'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_total' => ['required'],
            'max_discount' => ['required'],
            'quantity' => ['required', 'integer', 'min:1'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'expiration_date' => ['required', 'date', 'after_or_equal:today'],
        ], [
            'name.required' => 'Tên khuyến mãi không được để trống.',
            'code.required' => 'Mã khuyến mãi không được để trống.',
            'code.min' => 'Mã khuyến mãi phải có ít nhất 4 ký tự.',
            'code.unique' => 'Mã khuyến mãi đã tồn tại, vui lòng nhập mã khác.',
            'value.required' => 'Giá trị khuyến mãi không được để trống.',
            'value.numeric' => 'Giá trị khuyến mãi phải là số.',
            'value.min' => 'Giá trị khuyến mãi phải lớn hơn hoặc bằng 0.',
            'min_total.required' => 'Không được trống.',
            'max_discount.required' => 'Không được trống.',
            'quantity.required' => 'Số lượng không được để trống.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi.',
            'expiration_date.required' => 'Ngày hết hạn không được để trống.',
            'expiration_date.date' => 'Ngày hết hạn không hợp lệ.',
            'expiration_date.after_or_equal' => 'Ngày hết hạn phải từ hôm nay trở đi.',
        ]);

        $voucher->update($data);
        event(new \App\Events\Voucher($voucher));

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật khuyến mãi thành công.'

        ], Response::HTTP_OK);
    }


    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        event(new \App\Events\Voucher($voucher));
        return redirect()->back()->with('success', 'Xóa thành công.');
    }
}
