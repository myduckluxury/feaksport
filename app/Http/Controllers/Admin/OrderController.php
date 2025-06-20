<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderChange;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Reason;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    public function index()
    {
        $query = Order::query();

        if ($keyword = request()->keyword) {
            $query->where('order_code', 'like', "%$keyword%");
        }

        if ($status = request()->status) {
            $query->where('status', $status);
        }

        $orders = $query->latest('id')->paginate(10);
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD)',
            'VNPAY' => "Thanh toán qua VNPay",
            'MOMO' => 'Ví điện tử MOMO'
        ];
        $payment_status = [
            'unpaid' => ['value' => 'Chưa thanh toán.', 'class' => 'text-secondary'],
            'paid' => ['value' => 'Đã thanh toán.', 'class' => 'text-primary'],
            'refunded' => ['value' => 'Hoàn tiền.', 'class' => 'text-warning'],
            'cancel' => ['value' => 'Hủy thanh toán.', 'class' => 'text-danger']
        ];
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
            'failed' => ['value' => 'Thất bại.', 'class' => 'text-danger'],
            'returning' => ['value' => 'Đang hoàn hàng.', 'class' => 'text-warning'],
            'returned' => ['value' => 'Đơn hoàn trả.', 'class' => 'text-warning'],

        ];

        return view('admin.order.index', compact('orders', 'payment_method', 'payment_status', 'status'));
    }

    public function detail(Order $order)
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        $requestCancel = Reason::where('order_id', $order->id)->where('type', 'cancel')->where('status', 'pending')->first();
        $requestReturn = Reason::where('order_id', $order->id)->where('type', 'return')->first();
        $payment_method = [
            'COD' => 'Thanh toán khi nhận hàng (COD).',
            'VNPAY' => "Thanh toán qua VNPay.",
            'MOMO' => 'Ví điện tử MOMO.'
        ];
        $payment_status = [
            'unpaid' => ['value' => 'Chưa thanh toán.', 'class' => 'text-primary'],
            'paid' => ['value' => 'Đã thanh toán.', 'class' => 'text-success'],
            'refunded' => ['value' => 'Hoàn tiền.', 'class' => 'text-warning'],
            'cancel' => ['value' => 'Hủy thanh toán.', 'class' => 'text-danger']
        ];
        $status = [
            'unconfirmed' => ['value' => 'Chờ xác nhận.', 'class' => 'text-secondary'],
            'confirmed' => ['value' => 'Đã xác nhận.', 'class' => 'text-primary'],
            'shipping' => ['value' => 'Đang giao hàng.', 'class' => 'text-warning'],
            'delivered' => ['value' => 'Đã giao hàng.', 'class' => 'text-primary'],
            'completed' => ['value' => 'Hoàn thành.', 'class' => 'text-success'],
            'canceled' => ['value' => 'Hủy đơn.', 'class' => 'text-danger'],
            'failed' => ['value' => 'Thất bại.', 'class' => 'text-danger'],
            'returning' => ['value' => 'Đang hoàn hàng.', 'class' => 'text-warning'],
            'returned' => ['value' => 'Đơn hoàn trả.', 'class' => 'text-warning'],
        ];
        $day = ucfirst(mb_strtolower($order->created_at->locale('vi')->translatedFormat('l')));
        ;

        return view('admin.order.detail', compact('orderItems', 'order', 'payment_status', 'payment_method', 'status', 'day', 'requestCancel', 'requestReturn'));
    }

    public function updatePayment(Request $request, Order $order)
    {
        if ($request['payment_status']) {
            $order['payment_status'] = $request['payment_status'];
            $order->save();
            event(new OrderChange($order->id));

            OrderHistory::create([
                'order_id' => $order->id,
                'admin_id' => Auth::user()->id,
                'action' => 'refunded',
                'note' => 'Cập nhật trạng thái thanh toán hoàn tiền lại khách hàng.',
                'changed_at' => Carbon::now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có trạng thái nào được chọn.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateInfo(Request $request, Order $order)
    {
        $data = $request->validate([
            'fullname' => ['required', 'min:4'],
            'phone_number' => ['required', 'phone:VN'],
            'email' => ['required', 'email'],
            'address' => ['required', 'min:4'],
            'note' => ['nullable']
        ], [
            'fullname.required' => 'Không được để trống.',
            'fullname.min' => 'Tối thiểu 4 ký tự.',
            'phone_number.required' => 'Không được để trống.',
            'phone_number.phone' => 'Số không hợp lệ.',
            'email.required' => 'Không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'address.required' => 'Không được để trống.',
            'address.min' => 'Tối thiểu 4 ký tự.',
        ]);

        $order->update($data);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'info',
            'note' => 'Cập nhật thông tin khách hàng trên đơn hàng.',
            'changed_at' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function status(Request $request, Order $order)
    {
        if ($request->input('action') == 'confirmed') {
            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if (!$variant) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Sản phẩm không tồn tại.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }

                if ($item->quantity > $variant->quantity) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Số lượng hàng trong kho không đủ.'
                    ], Response::HTTP_INTERNAL_SERVER_ERROR);
                }
            }

            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->quantity -= $item->quantity;
                    $variant->save();
                }
            }

            $order->status = 'confirmed';
            $order->save();
            event(new OrderChange($order->id));

            OrderHistory::create([
                'order_id' => $order->id,
                'admin_id' => Auth::user()->id,
                'action' => 'confirmed',
                'note' => 'Xác nhận đơn hàng.',
                'changed_at' => Carbon::now()
            ]);

            $reason = Reason::where('order_id', $order->id)->first();

            if ($reason) {
                $reason->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'shipping') {
            $order->status = 'shipping';
            $order->save();
            event(new OrderChange($order->id));

            OrderHistory::create([
                'order_id' => $order->id,
                'admin_id' => Auth::user()->id,
                'action' => 'shipping',
                'note' => 'Cập nhật trạng thái đơn hàng "đang giao".',
                'changed_at' => Carbon::now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'delivered') {
            if ($order->user_id == null) {
                $order->update([
                    'status' => 'completed',
                    'payment_status' => 'paid'
                ]);
                event(new OrderChange($order->id));

                OrderHistory::create([
                    'order_id' => $order->id,
                    'admin_id' => Auth::user()->id,
                    'action' => 'delivered',
                    'note' => 'Cập nhật trạng thái đơn hàng "Hoàn thành".',
                    'changed_at' => Carbon::now()
                ]);
            } else {
                $order->update([
                    'status' => 'delivered',
                    'payment_status' => 'paid'
                ]);
                event(new OrderChange($order->id));

                OrderHistory::create([
                    'order_id' => $order->id,
                    'admin_id' => Auth::user()->id,
                    'action' => 'delivered',
                    'note' => 'Cập nhật trạng thái đơn hàng "giao thành công".',
                    'changed_at' => Carbon::now()
                ]);
            }

            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    Product::where('id', $variant->product_id)->increment('sales_count');
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'redeliver') {
            $order->status = 'shipping';
            $order->save();
            event(new OrderChange($order->id));

            OrderHistory::create([
                'order_id' => $order->id,
                'admin_id' => Auth::user()->id,
                'action' => 'redeliver',
                'note' => 'Cập nhật trạng thái đơn hàng "giao lại".',
                'changed_at' => Carbon::now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

        if ($request->input('action') == 'returned') {
            $order->status = 'returned';
            $order->save();
            event(new OrderChange($order->id));

            OrderHistory::create([
                'order_id' => $order->id,
                'admin_id' => Auth::user()->id,
                'action' => 'returned',
                'note' => 'Cập nhật trạng thái đơn hàng "hoàn trả thành công".',
                'changed_at' => Carbon::now()
            ]);

            foreach ($order->orderItems as $item) {
                $variant = ProductVariant::find($item->product_variant_id);
                if ($variant) {
                    $variant->quantity += $item->quantity;
                    $variant->save();
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công.'
            ], Response::HTTP_OK);
        }

    }

    public function cancel(Request $request, Order $order)
    {
        $adminId = Auth::user()->id;

        $order->update([
            'admin_id' => $adminId,
            'status' => 'canceled',
            'reason_cancel' => $request->reason
        ]);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'canceled',
            'note' => 'Hủy đơn hàng.',
            'changed_at' => Carbon::now()
        ]);

        if ($order->payment_method == 'COD') {
            $order->update([
                'payment_status' => 'cancel'
            ]);
        }

        $reason = Reason::where('order_id', $order->id)->first();

        if ($reason) {
            $reason->update([
                'status' => 'approved',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function failed(Request $request, Order $order)
    {
        $order->update([
            'status' => 'failed',
            'reason_failed' => $request->reason
        ]);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'failed',
            'note' => 'Cập nhật trạng thái đơn hàng "giao hàng thất bại".',
            'changed_at' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function returned(Request $request, Order $order)
    {
        $order->update([
            'status' => 'returning',
            'reason_returned' => $request->reason
        ]);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'returning_shipper',
            'note' => 'Tạo yêu cầu hoàn lại đơn hàng.',
            'changed_at' => Carbon::now()
        ]);

        if ($order->payment_method == 'COD') {
            $order->update([
                'payment_status' => 'cancel'
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function return_confirm(Request $request, Order $order)
    {
        $order->update([
            'status' => 'returning',
            'reason_returned' => $request->reason
        ]);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'returning_custom',
            'note' => 'Xác nhận yêu cầu hoàn trả từ khách hàng.',
            'changed_at' => Carbon::now()
        ]);

        $reason = Reason::where('order_id', $order->id)->first();

        if ($reason) {
            $reason->update([
                'status' => 'approved',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

    public function cancel_return(Request $request, Reason $requestReturn)
    {
        $requestReturn->update([
            'status' => 'rejected',
            'admin_note' => $request->reason
        ]);

        $order = Order::find($requestReturn->order_id);
        $order->update([
            'status' => 'completed'
        ]);
        event(new OrderChange($order->id));

        OrderHistory::create([
            'order_id' => $order->id,
            'admin_id' => Auth::user()->id,
            'action' => 'cancel-return',
            'note' => 'Từ chối yêu cầu hoàn trả từ khách hàng.',
            'changed_at' => Carbon::now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thành công.'
        ], Response::HTTP_OK);
    }

}
