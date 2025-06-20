<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Order;
use App\Models\Review;

class CheckPurchase
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $hasPurchased = false;
        $unreviewedVariants = [];

        if ($user) {
           
            $orderId = $request->input('order_id');

            if ($orderId) {
                // Kiểm tra đơn hàng thuộc về user và có chứa variant này
                $order = Order::where('id', $orderId)
                    ->where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->first();


                if ($order) {
                    // Lấy tất cả các orderItems và kiểm tra xem có bị đánh giá chưa
                    $orderItems = $order->orderItems;
                    foreach ($orderItems as $orderItem) {
                        $variantId = $orderItem->product_variant_id;

                        // Kiểm tra đã review chưa cho mỗi biến thể
                        $hasReviewed = Review::where('user_id', $user->id)
                            ->where('order_id', $orderId)
                            ->where('product_variant_id', $variantId)
                            ->exists();

                        // Nếu chưa đánh giá, thêm vào danh sách sản phẩm chưa được đánh giá
                        if (count($unreviewedVariants) > 0) {
                            $hasPurchased = true;
                        }
                    }
                }
            }
        }

        // Chia sẻ biến hasPurchased vào tất cả các view
            View::share('hasPurchased', $hasPurchased);
            View::share('unreviewedVariants', $unreviewedVariants);

            return $next($request);
    }

}







