<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    
    // Danh sách tất cả các đánh giá
    public function index(Request $request) {
        $query = Review::with(['order', 'product', 'user']);

    if ($request->filled('order_code')) {
        $query->whereHas('order', function ($q) use ($request) {
            $q->where('order_code', 'like', '%' . $request->order_code . '%');
        });
    }

    if ($request->filled('review_date')) {
        $query->whereDate('created_at', $request->review_date);
    }
    
    if ($request->filled('rating')) {
        $query->where('rating', $request->rating);
    }

    $reviews = $query->latest()->paginate(10);

    return view('admin.reviews.index', compact('reviews'));
    }

    // Ẩn hoặc hiện đánh giá
    public function hide($id)
    {
        $review = Review::findOrFail($id);
        $review->status =  !$review->status; // Đảo ngược trạng thái
        $review->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
    public function show($id)
    {
        $review = Review::with(['user', 'product', 'variant', 'order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }
}
