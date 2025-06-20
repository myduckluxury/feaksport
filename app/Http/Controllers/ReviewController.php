<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'product_variant_id' => 'required|exists:product_variants,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'required|string|max:255',
            'comment' => 'required|string|max:1500',
            'images.*' => 'nullable|mimes:jpeg,png,jpg,webp,avif|max:4080', // Kiểm tra ảnh
        ], [
            'images.*' => 'Tệp phải là ảnh.'
        ]);

        // Thêm đoạn này ngay sau validate
        if (!$request->filled('order_id') || !$request->filled('product_variant_id')) {
            return back()->with('error', 'Thiếu thông tin sản phẩm hoặc đơn hàng.');
        }

        $user = Auth::user();

        // Kiểm tra đơn hàng có thuộc về user và chứa sản phẩm đó không
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereHas('orderItems', function ($query) use ($request) {
                $query->where('product_variant_id', $request->product_variant_id);
            })
            ->first();

        if (!$order) {
            return back()->with('error', 'Bạn không thể đánh giá sản phẩm này cho đơn hàng đã chọn.');
        }

        // Kiểm tra đã đánh giá chưa
        $alreadyReviewed = Review::where('user_id', $user->id)
            ->where('product_variant_id', $request->product_variant_id)
            ->where('order_id', $request->order_id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này cho đơn hàng này rồi.');
        }
        // Xử lý hình ảnh 
        $imagePaths = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');

            if (count($images) > 3) {
                return back()->with('error', 'Bạn chỉ được tải lên tối đa 3 ảnh.');
            }

            foreach ($images as $image) {
                $path = $image->store('reviews', 'public'); 
                $imagePaths[] = $path;
            }
        }
        // lưu đánh giá vào csdl
        Review::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'product_variant_id' => $request->product_variant_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'images' => json_encode($imagePaths), // Lưu các đường dẫn ảnh dưới dạng JSON
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderId = $request->input('order_id');

        // Lấy danh sách sản phẩm đã mua trong đơn hàng này (kèm biến thể)
        $orderItems = OrderItem::with(['productVariant.product'])
            ->where('order_id', $orderId)
            ->whereHas('order', fn($q) => $q->where('user_id', Auth::id())->where('status', 'completed'))
            ->get();

        // Bỏ những item đã đánh giá rồi
        $orderItems = $orderItems->filter(function ($item) use ($orderId) {
            return !Review::where('user_id', Auth::id())
                ->where('order_id', $orderId)
                ->where('product_variant_id', $item->product_variant_id)
                ->exists();
        });

        return view('reviews.create', compact('orderItems', 'orderId'));
    }


    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
