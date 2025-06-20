<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WishlistController extends Controller
{
    //
    // Yêu cầu đăng nhập trước khi truy cập bất kỳ phương thức nào trong controller này.
     //
    public function __construct()
    {
        $this->middleware('auth');
    }

    
     //Hiển thị danh sách sản phẩm yêu thích của người dùng hiện tại.
     // Lấy tất cả wishlist của user hiện tại và truyền dữ liệu sang view.
     //
    public function index()
    {
        // Lấy danh sách wishlist của user hiện tại
        $wishlists = Wishlist::with('product')
            ->where('user_id', auth()->id())
            ->get();

        // Trả về view hiển thị danh sách sản phẩm yêu thích
        return view('client.wishlist.index', compact('wishlists'));
    }

    //
     // Thêm một sản phẩm vào danh sách yêu thích.
     // Kiểm tra nếu sản phẩm đã tồn tại trong wishlist, nếu chưa thì thêm mới.
     //
    public function add(Request $request, Product $product)
    {
        if(!auth()->check()){
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào danh sách yêu thích!'
            ], 401);
        }
        // Kiểm tra sản phẩm đã có trong danh sách yêu thích chưa
        $exists = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        // Nếu sản phẩm đã có trong danh sách, hiển thị thông báo lỗi
        if ($exists) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm đã có trong danh sách yêu thích!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Lấy biến thể sản phẩm đầu tiên (nếu có) để lấy giá
        $productVariant = ProductVariant::where('product_id', $product->id)->first();

        // Nếu có biến thể, lấy giá của biến thể, nếu không lấy giá từ sản phẩm chính
        $price = $productVariant ? $productVariant->price : $product->price;

        // Nếu sản phẩm không có giá, không cho phép thêm vào danh sách yêu thích
        if (!$price) {
            return redirect()
                ->route('wishlist.index')
                ->with('error', 'Sản phẩm chưa có giá, không thể thêm vào danh sách yêu thích!');
        }

        // Tạo bản ghi wishlist mới
        Wishlist::create([
            'user_id'   => Auth::id(),
            'product_id' => $product->id,
            'price'     => $price,
            'image'     => $product->image,
        ]);

        // Chuyển hướng về danh sách wishlist và hiển thị thông báo thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Đã thêm vào danh sách yêu thích!'
        ], Response::HTTP_OK);
    }

    //
    // Xóa một sản phẩm khỏi danh sách yêu thích.
     // Chỉ cho phép xóa nếu sản phẩm thuộc về người dùng hiện tại.
     //
    public function remove($id)
    {
        // Tìm sản phẩm trong wishlist theo ID và kiểm tra quyền sở hữu
        $wishlist = Wishlist::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        // Nếu sản phẩm không tồn tại trong danh sách, hiển thị thông báo lỗi
        if (!$wishlist) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại trong danh sách yêu thích!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Xóa sản phẩm khỏi wishlist
        $wishlist->delete();

        // Chuyển hướng về danh sách wishlist và hiển thị thông báo thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Đã xóa khỏi danh sách yêu thích!'
        ], Response::HTTP_OK);
    }
}
